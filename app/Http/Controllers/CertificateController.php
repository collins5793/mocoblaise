<?php
namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{

 public function index(Request $request)
    {
                $user = Auth::user();

        $query = Certificate::with(['user', 'course']);

        // Filtrage par utilisateur
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        // Filtrage par cours
        if ($request->filled('course')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->course . '%');
            });
        }
        if ($request->filled('date')) {
        $date = $request->input('date');
        $query->whereDate('generated_at', $date);
    }

        $certificates = $query->paginate(15)->appends($request->all());

        return view('admin.certificates.index', compact('certificates'));
    }

    public function exportCsv(Request $request)
    {
                $user = Auth::user();

        $query = Certificate::with(['user', 'course']);

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('course')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->course . '%');
            });
        }

        $certificates = $query->get();

        $response = new StreamedResponse(function () use ($certificates) {
            $handle = fopen('php://output', 'w');
            // En-têtes CSV
            fputcsv($handle, ['ID', 'Utilisateur', 'Cours', 'PDF URL', 'Date de génération']);

            foreach ($certificates as $cert) {
                fputcsv($handle, [
                    $cert->id,
                    $cert->user->name ?? '',
                    $cert->course->title ?? '',
                    asset('storage/' . $cert->pdf_url),
                    $cert->generated_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($handle);
        });

        $filename = 'certificats_export_' . date('Ymd_His') . '.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
    public function generate($courseId)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a déjà un certificat
        $existing = Certificate::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if ($existing) {
            return redirect()->back()->with('message', 'Certificat déjà généré.');
        }

        // Vérifier que le cours est complété (tu peux reprendre ta fonction ici)
        if (!$this->isCourseCompletedByUser($user->id, $courseId)) {
            return redirect()->back()->with('error', 'Cours non encore terminé.');
        }

        $course = Course::findOrFail($courseId);

        // Générer le PDF
        $pdf = Pdf::loadView('certificates.template', [
            'user' => $user,
            'course' => $course,
            'date' => now()->format('d/m/Y'),
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'certificat_' . $user->id . '_' . $courseId . '.pdf';
        $filePath = 'certificates/' . $filename;

        // Enregistrer le PDF sur le disque public
        Storage::disk('public')->put($filePath, $pdf->output());

        // Enregistrer en base sans le préfixe 'storage/'
        Certificate::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'pdf_url' => $filePath,  // juste certificates/nom.pdf
            'generated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Certificat généré avec succès.');
    }

    public function download($courseId)
    {
        $user = Auth::user();

        // Recherche le certificat
        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if (!$certificate) {
            return redirect()->back()->with('error', 'Certificat introuvable.');
        }

        // Construire le chemin correct vers le fichier
        $filePath = storage_path('app/public/' . $certificate->pdf_url);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Fichier du certificat manquant.');
        }

        return response()->download($filePath);
    }

    protected function isCourseCompletedByUser($userId, $courseId)
    {
                $user = Auth::user();

        // Vérifier si l'utilisateur a terminé toutes les leçons du cours
        $totalLessons = \App\Models\Lesson::where('course_id', $courseId)->count();

        $completedLessons = \App\Models\UserProgress::where('user_id', $userId)
            ->whereIn('lesson_id', function ($query) use ($courseId) {
                $query->select('id')
                      ->from('lessons')
                      ->where('course_id', $courseId);
            })
            ->where('is_completed', true)
            ->count();

        return $totalLessons > 0 && $totalLessons == $completedLessons;
    }
}
