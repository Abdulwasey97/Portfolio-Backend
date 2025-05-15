<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Pages\Index as PagesIndex;
use App\Livewire\Pages\Form as PagesForm;
use App\Livewire\Pages\Detail as PagesDetail;
use App\Livewire\Sections\Index as SectionsIndex;
use App\Livewire\Sections\Form as SectionsForm;
use App\Livewire\Sections\Detail as SectionsDetail;
use App\Livewire\Projects\Index as ProjectsIndex;
use App\Livewire\Projects\Form as ProjectsForm;
use App\Livewire\Projects\Detail as ProjectsDetail;
use Illuminate\Support\Facades\Auth;

// Login route
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Pages routes
    Route::get('/pages', PagesIndex::class)->name('pages.index');
    Route::get('/pages/create', PagesForm::class)->name('pages.create');
    Route::get('/pages/{id}/edit', PagesForm::class)->name('pages.edit');
    Route::get('/pages/{id}', PagesDetail::class)->name('pages.detail');

    // Sections routes
    Route::get('/sections', SectionsIndex::class)->name('sections.index');
    Route::get('/sections/create', SectionsForm::class)->name('sections.create');
    Route::get('/sections/{id}/edit', SectionsForm::class)->name('sections.edit');
    Route::get('/sections/{id}', SectionsDetail::class)->name('sections.detail');

    // Projects routes
    Route::get('/projects', ProjectsIndex::class)->name('projects.index');
    Route::get('/projects/create', ProjectsForm::class)->name('projects.create');
    Route::get('/projects/{id}/edit', ProjectsForm::class)->name('projects.edit');
    Route::get('/projects/{id}', ProjectsDetail::class)->name('projects.detail');
});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');
