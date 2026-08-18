<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ModeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\EquipeController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\TalentController;
use App\Http\Controllers\Admin\OeuvreController as AdminOeuvreController;
use App\Http\Controllers\Admin\SousmenuController;
use App\Http\Controllers\Admin\ActualiteController;
use App\Http\Controllers\Admin\EvenementController;
use App\Http\Controllers\Admin\AssociationController;
use App\Http\Controllers\Learner\DashboardController;
use App\Http\Controllers\ReservationActionController;
use App\Http\Controllers\TalentCandidatureController;
use App\Http\Controllers\Admin\CategorieCoursController;
use App\Http\Controllers\Admin\CategorieTalentController;
use App\Http\Controllers\Professeur\ProfesseurController;
use App\Http\Controllers\Admin\CategorieGalerieController;
use App\Http\Controllers\DonController;
use App\Http\Controllers\Admin\ProfilpermissionController;
use App\Http\Controllers\Admin\CategorieEvenementController;
use App\Http\Controllers\Professeur\DisponibiliteController;
use App\Http\Controllers\Professeur\ProfesseurCoursController;
use App\Http\Controllers\Professeur\ProfesseurSupportController;
use App\Http\Controllers\GalerieController as PublicGalerieController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\GalerieController as AdminGalerieController;
use App\Http\Controllers\Admin\ProfesseurController as AdminProfesseurController;

use App\Http\Controllers\Admin\TalentCandidatureController as AdminTalentCandidatureController;

// Public Pages Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'aPropos'])->name('a-propos');
Route::get('/actions', [HomeController::class, 'actions'])->name('actions');
Route::get('/talents', [HomeController::class, 'talents'])->name('talents');
Route::get('/talents/{id}', [HomeController::class, 'showTalent'])->name('talents.show');
Route::get('/evenements', [HomeController::class, 'evenements'])->name('evenements');
Route::get('/evenements/{id}', [HomeController::class, 'showEvenement'])->name('evenements.show');
Route::get('/galerie', [PublicGalerieController::class, 'index'])->name('galerie');
Route::get('/cours', [HomeController::class, 'cours'])->name('cours');
Route::get('/api/cours/{id}/slots', [ReservationController::class, 'getSlotsForCourse'])->name('api.cours.slots');

// Donation Route
Route::post('/don', [DonController::class, 'store'])->name('don.store');

// Resourceful Reservations Route
Route::middleware('auth')->group(function () {
    Route::resource('reservations', ReservationController::class);
});
Route::get('/galerie', [HomeController::class, 'galerie'])->name('galerie');
Route::get('/actualites', [HomeController::class, 'actualites'])->name('actualites');
Route::get('/actualites/{id}', [HomeController::class, 'showActualite'])->name('actualites.show');
Route::get('/don', [HomeController::class, 'don'])->name('don');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::post('/talent-candidatures', [TalentCandidatureController::class, 'store'])->name('talent-candidatures.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();

    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Votre compte a été validé avec succès. Veuillez vous connecter.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Un nouveau lien de vérification a été envoyé à votre adresse email.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Secure Dashboard Routes
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Apprenant routes
    Route::middleware(['role:apprenant', 'verified'])->group(function () {
        Route::get('/apprenant', [DashboardController::class, 'index'])->name('dashboard.apprenant');
        Route::get('/apprenant/cours', [DashboardController::class, 'cours'])->name('dashboard.apprenant.cours');
        Route::get('/apprenant/profile', [DashboardController::class, 'profile'])->name('dashboard.apprenant.profile');
        Route::put('/apprenant/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.apprenant.profile.update');
        Route::get('/apprenant/reservations', [DashboardController::class, 'reservations'])->name('dashboard.apprenant.reservations');

        // Actions de réservation (Apprenant)
        Route::post('/apprenant/reservations/{id}/accept', [ReservationActionController::class, 'accept'])->name('dashboard.apprenant.reservations.accept');
        Route::post('/apprenant/reservations/{id}/refuse', [ReservationActionController::class, 'refuse'])->name('dashboard.apprenant.reservations.refuse');
        Route::post('/apprenant/reservations/{id}/propose-report', [ReservationActionController::class, 'proposeReport'])->name('dashboard.apprenant.reservations.proposeReport');
        Route::get('/apprenant/reservations/{id}/discussions', [ReservationActionController::class, 'showDiscussions'])->name('dashboard.apprenant.reservations.discussions');

        Route::get('/apprenant/upcoming', [DashboardController::class, 'upcoming'])->name('dashboard.apprenant.upcoming');
        Route::get('/apprenant/supports', [DashboardController::class, 'supports'])->name('dashboard.apprenant.supports');
        Route::get('/apprenant/supports/{id}/download', [DashboardController::class, 'downloadSupport'])->name('dashboard.apprenant.supports.download');
        Route::get('/meeting/{reservation}', [MeetingController::class, 'show'])->name('meeting.show');
    });

    // Professeur routes
    Route::middleware(['role:professeur', 'verified'])->group(function () {
        Route::get('/professeur', [ProfesseurController::class, 'index'])->name('dashboard.professeur');
        Route::get('/professeur/profile', [ProfesseurController::class, 'profile'])->name('dashboard.professeur.profile');
        Route::put('/professeur/profile', [ProfesseurController::class, 'updateProfile'])->name('dashboard.professeur.profile.update');
        Route::resource('professeur/disponibilites', DisponibiliteController::class)->names('dashboard.professeur.disponibilites');
        Route::get('/professeur/reservations', [ProfesseurController::class, 'reservations'])->name('dashboard.professeur.reservations');
        Route::post('/professeur/reservations/{id}/accept', [ReservationActionController::class, 'accept'])->name('dashboard.professeur.reservations.accept');
        Route::post('/professeur/reservations/{id}/refuse', [ReservationActionController::class, 'refuse'])->name('dashboard.professeur.reservations.refuse');
        Route::post('/professeur/reservations/{id}/propose-report', [ReservationActionController::class, 'proposeReport'])->name('dashboard.professeur.reservations.proposeReport');
        Route::get('/professeur/reservations/{id}/discussions', [ReservationActionController::class, 'showDiscussions'])->name('dashboard.professeur.reservations.discussions');
        Route::get('/professeur/eleves', [ProfesseurController::class, 'eleves'])->name('dashboard.professeur.eleves');
        Route::get('/professeur/eleves/{id}/suivi', [ProfesseurController::class, 'suiviEleve'])->name('dashboard.professeur.eleves.suivi');
        Route::resource('professeur/cours', ProfesseurCoursController::class)->names('dashboard.professeur.cours');
        Route::get('professeur/cours/{cours}/download-support', [ProfesseurCoursController::class, 'downloadSupport'])->name('dashboard.professeur.cours.download-support');
        Route::resource('professeur/supports', ProfesseurSupportController::class)->names('dashboard.professeur.supports');
    });

    // Meeting routes (accessible par professeur et apprenant)
    Route::middleware('auth')->group(function () {
        Route::get('/meeting/{reservation}', [MeetingController::class, 'show'])->name('meeting.show');
        Route::post('/meeting/{reservation}/regenerate-token', [MeetingController::class, 'regenerateToken'])->name('meeting.regenerate-token');
        Route::get('/meeting/{reservation}/replay', [MeetingController::class, 'viewReplay'])->name('meeting.replay');
        Route::post('/meeting/{reservation}/replay', [MeetingController::class, 'storeReplay'])->name('meeting.replay.store');
    });

    // Admin routes
    Route::middleware('role:administrateur')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('dashboard.admin');
        Route::resource('/admin/professeurs', AdminProfesseurController::class)->names('dashboard.admin.professeurs');
        Route::resource('/admin/talents', TalentController::class)->names('dashboard.admin.talents');
        Route::resource('/admin/talents-oeuvres', AdminOeuvreController::class)->names('dashboard.admin.talents.oeuvres');
        Route::get('/admin/talent-candidatures', [AdminTalentCandidatureController::class, 'index'])->name('dashboard.admin.talent-candidatures.index');
        Route::post('/admin/talent-candidatures/{talentCandidature}/approve', [AdminTalentCandidatureController::class, 'approve'])->name('dashboard.admin.talent-candidatures.approve');
        Route::post('/admin/talent-candidatures/{talentCandidature}/reject', [AdminTalentCandidatureController::class, 'reject'])->name('dashboard.admin.talent-candidatures.reject');
        Route::resource('/admin/categories-cours', CategorieCoursController::class)->names('dashboard.admin.categories-cours');
        Route::resource('/admin/categories-evenements', CategorieEvenementController::class)->names('dashboard.admin.categories-evenements');
        Route::resource('/admin/categories-talents', CategorieTalentController::class)->names('dashboard.admin.categories-talents');
        Route::resource('/admin/categories-galeries', CategorieGalerieController::class)->names('dashboard.admin.categories-galeries');
        Route::resource('/admin/galeries', AdminGalerieController::class)->names('dashboard.admin.galeries');
        Route::resource('/admin/actualites', ActualiteController::class)->names('dashboard.admin.actualites');
        Route::resource('/admin/associations', AssociationController::class)->names('dashboard.admin.associations');
        Route::resource('/admin/equipes', EquipeController::class)->names('dashboard.admin.equipes');
        Route::resource('/admin/modules', ModuleController::class)->names('dashboard.admin.modules');
        Route::resource('/admin/menus', MenuController::class)->names('dashboard.admin.menus');
        Route::resource('/admin/sousmenus', SousmenuController::class)->names('dashboard.admin.sousmenus');
        Route::resource('/admin/modes', ModeController::class)->names('dashboard.admin.modes');
        Route::get('/admin/membres', [\App\Http\Controllers\Admin\MembreController::class, 'index'])->name('dashboard.admin.membres.index');
        Route::resource('/admin/cours', CoursController::class)->names('dashboard.admin.cours');
        Route::resource('/admin/evenements', EvenementController::class)->names('dashboard.admin.evenements');
        Route::resource('/admin/profils', ProfilController::class)->names('dashboard.admin.profils');
        Route::resource('/admin/contacts', AdminContactController::class)->names('dashboard.admin.contacts');
        Route::get('/admin/profils/{profil}/permissions', [ProfilpermissionController::class, 'index'])->name('dashboard.admin.profils.permissions');
        Route::put('/admin/profils/{profil}/permissions', [ProfilpermissionController::class, 'update'])->name('dashboard.admin.profils.permissions.update');

        // Admin Profile Management
        Route::get('/admin/profile', [AdminController::class, 'profile'])->name('dashboard.admin.profile');
        Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('dashboard.admin.profile.update');
    });
});
