<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($role = $request->input('role')) {
        $query->where('role', $role);
    }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $user = User::findOrFail($id);

        // Optionnel : empêcher suppression admin ou toi-même
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function export()
    {if (Auth::user()->role !== 'admin') {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette page.');
        }
        $fileName = 'utilisateurs_'.date('Ymd_His').'.csv';

        $users = User::all();

        $response = new StreamedResponse(function() use ($users) {
            $handle = fopen('php://output', 'w');
            // En-têtes CSV
            fputcsv($handle, ['ID', 'Nom', 'Email', 'Rôle', 'Date inscription']);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$fileName\"");

        return $response;
    }

    
}
