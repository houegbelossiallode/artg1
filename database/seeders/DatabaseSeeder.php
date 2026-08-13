<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Profil;
use App\Models\User;
use App\Models\Association;
use App\Models\Equipe;
use App\Models\Mode;
use App\Models\CategorieCours;
use App\Models\Cours;
use App\Models\Actualite;
use App\Models\CategorieEvenement;
use App\Models\CategorieTalent;
use App\Models\Talent;
use App\Models\Oeuvre;
use App\Models\Evenement;
use App\Models\Constante;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Profils
        $adminProfil = Profil::firstOrCreate(['id' => 1, 'nom' => 'administrateur', 'actif' => 'OUI']);
        $profProfil = Profil::firstOrCreate(['id' => 2, 'nom' => 'professeur', 'actif' => 'OUI']);
        $apprenantProfil = Profil::firstOrCreate(['id' => 3, 'nom' => 'apprenant', 'actif' => 'OUI']);

        // 2. Users
        User::firstOrCreate([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@assoculture.com',
            'password' => Hash::make('password'),
            'profil_id' => 1,
            'sexe' => 'M',
            'date_naissance' => '1985-01-01',
            'biographie' => 'Administrateur général de la plateforme.',
            'telephone' => '+22900000001',
            'adresse' => 'Cotonou, Bénin',
            'actif' => 'OUI'
        ]);

        $teacher = User::firstOrCreate([
            'nom' => 'Dupont',
            'prenom' => 'Jean-Marc',
            'email' => 'jeanmarc@assoculture.com',
            'password' => Hash::make('password'),
            'profil_id' => 2,
            'sexe' => 'M',
            'date_naissance' => '1978-05-15',
            'biographie' => 'Professeur de guitare et percussions traditionnelles avec plus de 15 ans d\'expérience.',
            'telephone' => '+22900000002',
            'adresse' => 'Porto-Novo, Bénin',
            'actif' => 'OUI'
        ]);

        $student = User::firstOrCreate([
            'nom' => 'Martin',
            'prenom' => 'Alice',
            'email' => 'alice@assoculture.com',
            'password' => Hash::make('password'),
            'profil_id' => 3,
            'sexe' => 'F',
            'date_naissance' => '2000-09-20',
            'biographie' => 'Étudiante passionnée de tissage de raphia et d\'arts musicaux traditionnels.',
            'telephone' => '+22900000003',
            'adresse' => 'Ouidah, Bénin',
            'actif' => 'OUI'
        ]);

        // // 3. Associations
        // Association::create([
        //     'nom' => 'AssoCulture Bénin',
        //     'logo' => 'logo.png',
        //     'historique' => 'Fondée en 2015, AssoCulture œuvre pour la valorisation du patrimoine artistique local.',
        //     'mission' => 'Promouvoir les arts traditionnels, l\'artisanat du raphia et le développement des jeunes talents.',
        //     'vision' => 'Créer une communauté florissante et transmettre nos savoirs ancestraux aux générations futures.',
        //     'description' => 'AssoCulture est un carrefour d\'échange artistique, de formation musicale et de préservation artisanale.',
        //     'adresse' => 'Quartier Fidjrossè, Cotonou, Bénin',
        //     'telephone' => '+229 97 00 00 00',
        //     'email' => 'contact@assoculture.bj',
        //     'facebook' => 'https://facebook.com/assoculture',
        //     'youtube' => 'https://youtube.com/assoculture',
        //     'instagram' => 'https://instagram.com/assoculture',
        //     'site_web' => 'https://assoculture.org',
        //     'actif' => 'OUI'
        // ]);

        // // 4. Equipes
        // Equipe::create([
        //     'nom' => 'Koffi',
        //     'prenom' => 'Antoine',
        //     'fonction' => 'Directeur Artistique',
        //     'photo' => 'team-1.jpg',
        //     'biographie' => 'Pianiste de formation et défenseur de la musique traditionnelle béninoise.',
        //     'actif' => 'OUI'
        // ]);

        // Equipe::create([
        //     'nom' => 'Sossa',
        //     'prenom' => 'Marie',
        //     'fonction' => 'Responsable Artisanat & Raphia',
        //     'photo' => 'team-2.jpg',
        //     'biographie' => 'Artisane experte dans le tissage traditionnel et la teinture naturelle.',
        //     'actif' => 'OUI'
        // ]);

        // // 5. Modes
        // $presentielMode = Mode::create(['id' => 1, 'libelle' => 'Présentiel', 'actif' => 'OUI']);
        // $distancielMode = Mode::create(['id' => 2, 'libelle' => 'Distanciel', 'actif' => 'OUI']);
        // $hybrideMode = Mode::create(['id' => 3, 'libelle' => 'Hybride', 'actif' => 'OUI']);

        // // 6. CategorieCours
        // $catMusicTrad = CategorieCours::create(['id' => 1, 'nom' => 'Musique Traditionnelle', 'description' => 'Apprenez les instruments locaux (percussions, gong, etc.)', 'actif' => 'OUI']);
        // $catMusicMod = CategorieCours::create(['id' => 2, 'nom' => 'Musique Moderne', 'description' => 'Guitare acoustique, piano et chant moderne', 'actif' => 'OUI']);
        // $catRaphia = CategorieCours::create(['id' => 3, 'nom' => 'Artisanat & Raphia', 'description' => 'Techniques de tissage et création d\'accessoires décoratifs', 'actif' => 'OUI']);

        // // 7. Cours
        // Cours::create([
        //     'categorie_cours_id' => 2,
        //     'user_id' => $teacher->id,
        //     'titre' => 'Initiation à la Guitare Acoustique',
        //     'description' => 'Un cours complet pour maîtriser les accords de base et les rythmes modernes.',
        //     'tarif' => 15000,
        //     'mode_id' => 1,
        //     'actif' => 'OUI'
        // ]);

        // Cours::create([
        //     'categorie_cours_id' => 3,
        //     'user_id' => $teacher->id,
        //     'titre' => 'Tissage Traditionnel de Raphia',
        //     'description' => 'Découvrez l\'art du tissage et fabriquez votre premier sac ou chapeau en raphia.',
        //     'tarif' => 20000,
        //     'mode_id' => 1,
        //     'actif' => 'OUI'
        // ]);

        // // 8. Actualites
        // Actualite::create([
        //     'titre' => 'Lancement de la rentrée culturelle 2026',
        //     'contenu' => 'Les inscriptions aux ateliers d\'artisanat du raphia et de musique traditionnelle sont ouvertes à tous dès aujourd\'hui.',
        //     'photo' => 'news-1.jpg',
        //     'date_publication' => '2026-07-28',
        //     'actif' => 'OUI'
        // ]);

        // Actualite::create([
        //     'titre' => 'Exposition d\'artisanat local au Centre Culturel',
        //     'contenu' => 'AssoCulture présentera une sélection unique d\'œuvres faites à base de raphia naturel par les élèves de notre programme.',
        //     'photo' => 'news-2.jpg',
        //     'date_publication' => '2026-07-29',
        //     'actif' => 'OUI'
        // ]);

        // // 9. CategorieEvenement
        // CategorieEvenement::create(['id' => 1, 'libelle' => 'Concert', 'actif' => 'OUI']);
        // CategorieEvenement::create(['id' => 2, 'libelle' => 'Exposition', 'actif' => 'OUI']);
        // CategorieEvenement::create(['id' => 3, 'libelle' => 'Atelier', 'actif' => 'OUI']);

        // // 10. CategorieTalent
        // CategorieTalent::create(['id' => 1, 'libelle' => 'Musique', 'actif' => 'OUI']);
        // CategorieTalent::create(['id' => 2, 'libelle' => 'Artisanat', 'actif' => 'OUI']);
        // CategorieTalent::create(['id' => 3, 'libelle' => 'Danse Traditionnelle', 'actif' => 'OUI']);

        // // 11. Talents
        // $talentMusic = Talent::create([
        //     'id' => 1,
        //     'nom' => 'Agossou',
        //     'prenom' => 'Karel',
        //     'photo' => 'talent-1.jpg',
        //     'biographie' => 'Jeune batteur passionné par la fusion entre rythmes jazz et percussions traditionnelles béninoises.',
        //     'categorie_talent_id' => 1,
        //     'facebook' => 'https://facebook.com/karel.agossou',
        //     'youtube' => 'https://youtube.com/karel.agossou',
        //     'instagram' => 'https://instagram.com/karel.agossou',
        //     'telephone' => '+229 97 10 10 10',
        //     'email' => 'karel@example.com',
        //     'actif' => 'OUI'
        // ]);

        // $talentCraft = Talent::create([
        //     'id' => 2,
        //     'nom' => 'Zinsou',
        //     'prenom' => 'Florence',
        //     'photo' => 'talent-2.jpg',
        //     'biographie' => 'Designer d\'objets d\'intérieur, elle revisite le raphia traditionnel pour créer des décorations haut de gamme.',
        //     'categorie_talent_id' => 2,
        //     'facebook' => 'https://facebook.com/florence.zinsou',
        //     'youtube' => '',
        //     'instagram' => 'https://instagram.com/florence.zinsou',
        //     'telephone' => '+229 97 20 20 20',
        //     'email' => 'florence@example.com',
        //     'actif' => 'OUI'
        // ]);

        // // 12. Oeuvres
        // Oeuvre::create([
        //     'talent_id' => $talentMusic->id,
        //     'nom' => 'Rythmes Sauvages',
        //     'description' => 'Une démonstration live combinant tam-tam traditionnel et rythmique africaine modernisée.',
        //     'type' => 'video',
        //     'fichier' => 'rythmes_sauvages.mp4',
        //     'image' => 'oeuvre-1.jpg',
        //     'date_publication' => '2026-07-20',
        //     'actif' => 'OUI'
        // ]);

        // Oeuvre::create([
        //     'talent_id' => $talentCraft->id,
        //     'nom' => 'Panier Chic Raphia',
        //     'description' => 'Un panier tressé entièrement à la main avec du raphia teinté aux pigments naturels.',
        //     'type' => 'image',
        //     'fichier' => 'panier_chic.jpg',
        //     'image' => 'panier_chic.jpg',
        //     'date_publication' => '2026-07-22',
        //     'actif' => 'OUI'
        // ]);

        // // 13. Evenements
        // Evenement::create([
        //     'categorie_evenement_id' => 1,
        //     'titre' => 'Concert de Gala AssoCulture 2026',
        //     'gratuit' => 'non',
        //     'description' => 'Venez assister au grand concert annuel de musique de fusion réunissant professeurs et apprenants.',
        //     'date_debut' => '2026-08-25',
        //     'date_fin' => '2026-08-25',
        //     'heure' => '19:00:00',
        //     'lieu' => 'Théâtre National, Cotonou',
        //     'capacite' => 300,
        //     'photo' => 'event-1.jpg',
        //     'prix' => 5000,
        //     'actif' => 'OUI'
        // ]);

        // Evenement::create([
        //     'categorie_evenement_id' => 2,
        //     'titre' => 'Expo Raphia Création',
        //     'gratuit' => 'oui',
        //     'description' => 'Exposition éphémère ouverte au public mettant en lumière l\'artisanat local béninois.',
        //     'date_debut' => '2026-08-28',
        //     'date_fin' => '2026-08-30',
        //     'heure' => '10:00:00',
        //     'lieu' => 'Galerie d\'art de l\'Association, Cotonou',
        //     'capacite' => 150,
        //     'photo' => 'event-2.jpg',
        //     'prix' => 0,
        //     'actif' => 'OUI'
        // ]);

        // // 14. Constantes
        // Constante::create(['param' => 'site_title', 'val' => 'AssoCulture']);
        // Constante::create(['param' => 'allow_registrations', 'val' => 'true']);
        // Constante::create(['param' => 'contact_phone', 'val' => '+229 97 00 00 00']);
    }
}
