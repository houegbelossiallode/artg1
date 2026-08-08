<?php

$migrationsDir = __DIR__ . '/database/migrations/';

// Clean up existing migrations to start fresh
$files = glob($migrationsDir . '*.php');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

$tables = [
    'profils' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
            \$table->softDeletes();
PHP,
    'users' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->string('email')->unique()->nullable();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password')->nullable();
            \$table->rememberToken();
            \$table->string('prenom')->nullable();
            \$table->string('photo')->nullable();
            \$table->string('sexe')->nullable();
            \$table->date('date_naissance')->nullable();
            \$table->text('biographie')->nullable();
            \$table->string('telephone')->nullable();
            \$table->string('adresse')->nullable();
            \$table->foreignId('profil_id')->nullable()->constrained('profils');
            \$table->string('actif')->nullable();
            \$table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint \$table) {
            \$table->string('email')->primary();
            \$table->string('token');
            \$table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->foreignId('user_id')->nullable()->index();
            \$table->string('ip_address', 45)->nullable();
            \$table->text('user_agent')->nullable();
            \$table->longText('payload');
            \$table->integer('last_activity')->index();
PHP,
    'associations' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->string('logo')->nullable();
            \$table->string('historique')->nullable();
            \$table->string('mission')->nullable();
            \$table->string('vision')->nullable();
            \$table->string('description')->nullable();
            \$table->string('adresse')->nullable();
            \$table->string('telephone')->nullable();
            \$table->string('email')->nullable();
            \$table->string('facebook')->nullable();
            \$table->string('youtube')->nullable();
            \$table->string('instagram')->nullable();
            \$table->string('site_web')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'equipes' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->string('prenom')->nullable();
            \$table->string('fonction')->nullable();
            \$table->string('photo')->nullable();
            \$table->string('biographie')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'categorie_cours' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->text('description')->nullable();
            \$table->string('actif')->nullable();
PHP,
    'actualites' => <<<PHP
            \$table->id();
            \$table->string('titre')->nullable();
            \$table->string('contenu')->nullable();
            \$table->string('photo')->nullable();
            \$table->date('date_publication')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'categorie_evenements' => <<<PHP
            \$table->id();
            \$table->string('libelle')->nullable();
            \$table->string('actif')->nullable();
PHP,
    'categorie_talents' => <<<PHP
            \$table->id();
            \$table->string('libelle')->nullable();
            \$table->string('actif')->nullable();
PHP,
    'modes' => <<<PHP
            \$table->id();
            \$table->string('libelle')->nullable();
            \$table->string('actif')->nullable();
PHP,
    'modules' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'newsletters' => <<<PHP
            \$table->id();
            \$table->string('email')->nullable();
            \$table->string('statut')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'talents' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->string('prenom')->nullable();
            \$table->string('photo')->nullable();
            \$table->text('biographie')->nullable();
            \$table->foreignId('categorie_talent_id')->nullable()->constrained('categorie_talents');
            \$table->string('facebook')->nullable();
            \$table->string('youtube')->nullable();
            \$table->string('instagram')->nullable();
            \$table->string('telephone')->nullable();
            \$table->string('email')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'evenements' => <<<PHP
            \$table->id();
            \$table->foreignId('categorie_evenement_id')->nullable()->constrained('categorie_evenements');
            \$table->string('titre')->nullable();
            \$table->boolean('gratuit')->nullable();
            \$table->string('description')->nullable();
            \$table->date('date_debut')->nullable();
            \$table->date('date_fin')->nullable();
            \$table->time('heure')->nullable();
            \$table->string('lieu')->nullable();
            \$table->integer('capacite')->nullable();
            \$table->string('photo')->nullable();
            \$table->decimal('prix', 12, 2)->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'cours' => <<<PHP
            \$table->id();
            \$table->foreignId('categorie_cours_id')->nullable()->constrained('categorie_cours');
            \$table->foreignId('user_id')->nullable()->constrained('users');
            \$table->string('titre')->nullable();
            \$table->text('description')->nullable();
            \$table->date('date_cours')->nullable();
            \$table->time('heure_debut')->nullable();
            \$table->time('heure_fin')->nullable();
            \$table->integer('duree')->nullable();
            \$table->decimal('tarif', 12, 2)->nullable();
            \$table->foreignId('mode_id')->nullable()->constrained('modes');
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'menus' => <<<PHP
            \$table->id();
            \$table->string('nom')->nullable();
            \$table->foreignId('module_id')->nullable()->constrained('modules');
            \$table->string('icon')->nullable();
            \$table->string('url')->nullable();
            \$table->string('actif')->nullable();
PHP,
    'oeuvres' => <<<PHP
            \$table->id();
            \$table->foreignId('talent_id')->nullable()->constrained('talents');
            \$table->string('titre')->nullable();
            \$table->string('description')->nullable();
            \$table->string('type')->nullable();
            \$table->string('fichier')->nullable();
            \$table->string('image')->nullable();
            \$table->date('date_publication')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'diffusions_evenements' => <<<PHP
            \$table->id();
            \$table->foreignId('evenement_id')->nullable()->constrained('evenements');
            \$table->string('plateforme')->nullable();
            \$table->string('lien_reunion')->nullable();
            \$table->date('date_ouverture')->nullable();
            \$table->date('date_fermeture')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'support_cours' => <<<PHP
            \$table->id();
            \$table->foreignId('cours_id')->nullable()->constrained('cours');
            \$table->string('titre')->nullable();
            \$table->text('description')->nullable();
            \$table->string('fichier')->nullable();
            \$table->string('type')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'disponibilites' => <<<PHP
            \$table->id();
            \$table->foreignId('cours_id')->nullable()->constrained('cours');
            \$table->foreignId('professeur_id')->nullable()->constrained('users');
            \$table->string('statut')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'reservations' => <<<PHP
            \$table->id();
            \$table->foreignId('cours_id')->nullable()->constrained('cours');
            \$table->integer('user_id')->nullable();
            \$table->string('mode')->nullable();
            \$table->string('statut')->nullable();
            \$table->text('commentaire')->nullable();
            \$table->timestamp('date_reservation')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'sousmenus' => <<<PHP
            \$table->id();
            \$table->foreignId('menu_id')->nullable()->constrained('menus');
            \$table->string('nom')->nullable();
            \$table->string('url')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'inscription_evenements' => <<<PHP
            \$table->id();
            \$table->foreignId('evenement_id')->nullable()->constrained('evenements');
            \$table->foreignId('utilisateur_id')->nullable()->constrained('users');
            \$table->timestamp('date_inscription')->nullable();
            \$table->string('mode_paiement')->nullable();
            \$table->foreignId('mode_id')->nullable()->constrained('modes');
            \$table->decimal('montant', 12, 2)->nullable();
            \$table->string('statut')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'messages' => <<<PHP
            \$table->id();
            \$table->integer('expediteur_id')->nullable();
            \$table->integer('destinataire_id')->nullable();
            \$table->string('sujet')->nullable();
            \$table->text('message')->nullable();
            \$table->boolean('lu')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'paiement_evenements' => <<<PHP
            \$table->id();
            \$table->foreignId('inscription_id')->nullable()->constrained('inscription_evenements');
            \$table->string('reference')->nullable();
            \$table->decimal('montant', 12, 2)->nullable();
            \$table->string('moyen_paiement')->nullable();
            \$table->string('statut')->nullable();
            \$table->timestamp('date_paiement')->nullable();
PHP,
    'access_evenements' => <<<PHP
            \$table->id();
            \$table->foreignId('inscription_id')->nullable()->constrained('inscription_evenements');
            \$table->foreignId('reservation_id')->nullable()->constrained('reservations');
            \$table->foreignId('diffusion_id')->nullable()->constrained('diffusions_evenements');
            \$table->string('token')->nullable();
            \$table->timestamp('date_expiration')->nullable();
            \$table->timestamp('premiere_connexion')->nullable();
            \$table->timestamp('derniere_connexion')->nullable();
            \$table->boolean('utilise')->nullable();
            \$table->string('adresse_ip')->nullable();
            \$table->text('user_agent')->nullable();
            \$table->timestamps();
PHP,
    'billets' => <<<PHP
            \$table->id();
            \$table->foreignId('inscription_id')->nullable()->constrained('inscription_evenements');
            \$table->string('numero')->nullable();
            \$table->string('qr_code')->nullable();
            \$table->timestamp('date_generation')->nullable();
            \$table->string('statut')->nullable();
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
    'profilpermissions' => <<<PHP
            \$table->id();
            \$table->foreignId('profil_id')->nullable()->constrained('profils');
            \$table->foreignId('sousmenu_id')->nullable()->constrained('sousmenus');
            \$table->string('actif')->nullable();
            \$table->timestamps();
PHP,
];

// Add cache and jobs defaults to not break Laravel 11 base setup
$tables['cache'] = <<<PHP
            \$table->string('key')->primary();
            \$table->mediumText('value');
            \$table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint \$table) {
            \$table->string('key')->primary();
            \$table->string('owner');
            \$table->integer('expiration');
PHP;

$tables['jobs'] = <<<PHP
            \$table->id();
            \$table->string('queue')->index();
            \$table->longText('payload');
            \$table->unsignedTinyInteger('attempts');
            \$table->unsignedInteger('reserved_at')->nullable();
            \$table->unsignedInteger('available_at');
            \$table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->string('name');
            \$table->integer('total_jobs');
            \$table->integer('pending_jobs');
            \$table->integer('failed_jobs');
            \$table->longText('failed_job_ids');
            \$table->mediumText('options')->nullable();
            \$table->integer('cancelled_at')->nullable();
            \$table->integer('created_at');
            \$table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint \$table) {
            \$table->id();
            \$table->string('uuid')->unique();
            \$table->text('connection');
            \$table->text('queue');
            \$table->longText('payload');
            \$table->longText('exception');
            \$table->timestamp('failed_at')->useCurrent();
PHP;


$time = time();

foreach ($tables as $table => $schema) {
    $timestamp = date('Y_m_d_His', $time);
    $time++; // Increment by 1 second to ensure correct order
    
    $className = "Create" . str_replace(' ', '', ucwords(str_replace('_', ' ', $table))) . "Table";
    
    $downMethod = "Schema::dropIfExists('$table');";
    if ($table == 'users') {
        $downMethod = "Schema::dropIfExists('users');\n        Schema::dropIfExists('password_reset_tokens');\n        Schema::dropIfExists('sessions');";
    } else if ($table == 'cache') {
        $downMethod = "Schema::dropIfExists('cache');\n        Schema::dropIfExists('cache_locks');";
    } else if ($table == 'jobs') {
        $downMethod = "Schema::dropIfExists('jobs');\n        Schema::dropIfExists('job_batches');\n        Schema::dropIfExists('failed_jobs');";
    }

    $content = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('$table', function (Blueprint \$table) {
$schema
        });
    }

    public function down(): void
    {
        $downMethod
    }
};
PHP;

    $filename = $migrationsDir . $timestamp . "_create_{$table}_table.php";
    file_put_contents($filename, $content);
}

echo "Created " . count($tables) . " migrations.\n";

