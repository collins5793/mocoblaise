<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // Liste des domaines prédéfinis avec emojis
        $domaines = [
            ["nom" => "L'informatique", "emoji" => "💻"],
            ["nom" => "Langues et communication", "emoji" => "🗣️"],
            ["nom" => "Gestion et affaires", "emoji" => "📊"],
            ["nom" => "Professionnaliser", "emoji" => "🎓"],
            ["nom" => "Art et design", "emoji" => "🎨"],
            ["nom" => "Éducation de base", "emoji" => "🏫"],
            ["nom" => "Musique", "emoji" => "🎵"],
            ["nom" => "Esthétique", "emoji" => "💅"],
            ["nom" => "Santé", "emoji" => "🩺"],
            ["nom" => "Autres", "emoji" => "📚"],
        ];

        // Récupérer le nombre de cours par catégorie depuis la base
        $categories = Course::select('category')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Construire le tableau final avec emoji, nom, count, slug
        $categoriesFormatted = [];
        foreach ($domaines as $domaine) {
            $nom = $domaine['nom'];
            $categoriesFormatted[] = [
                'emoji' => $domaine['emoji'],
                'name'  => $nom,
                'count' => $categories[$nom] ?? 0,
                'slug'  => Str::slug($nom, '-'), // pour URL friendly
            ];
        }

        return view('home', ['categories' => $categoriesFormatted]);
    }
}
