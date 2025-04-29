<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use App\Models\Section;

class Dashboard extends Component
{
    public function mount()
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get counts for stats
        $pagesCount = Page::count();
        $sectionsCount = Section::count();
        $publishedPagesCount = Page::where('status', 'published')->count();

        // Get recent pages
        $recentPages = Page::latest()->take(5)->get();

        // Get recent sections
        $recentSections = Section::with('page')->latest()->take(5)->get();

        return view('livewire.dashboard', [
            'user' => $user,
            'pagesCount' => $pagesCount,
            'sectionsCount' => $sectionsCount,
            'publishedPagesCount' => $publishedPagesCount,
            'recentPages' => $recentPages,
            'recentSections' => $recentSections
        ])->layout('components.layouts.app', [
            'title' => 'Dashboard'
        ]);
    }
}
