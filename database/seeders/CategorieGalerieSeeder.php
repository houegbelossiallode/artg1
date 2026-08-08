<?php

namespace Database\Seeders;

use App\Models\CategorieGalerie;
use Illuminate\Database\Seeder;

class CategorieGalerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'libelle' => 'Photos',
                'slug' => 'photos',
                'description' => 'Photographies des événements et activités de l\'association',
                'actif' => 'OUI',
            ],
            [
                'libelle' => 'Vidéos',
                'slug' => 'videos',
                'description' => 'Vidéos des performances et événements',
                'actif' => 'OUI',
            ],
            [
                'libelle' => 'Artisanat',
                'slug' => 'artisanat',
                'description' => 'Créations artisanales et œuvres en raphia',
                'actif' => 'OUI',
            ],
        ];

        foreach ($categories as $category) {
            CategorieGalerie::create($category);
        }
    }
}
