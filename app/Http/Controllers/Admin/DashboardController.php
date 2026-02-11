<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\Group;
use App\Models\Mass;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news_count' => News::count(),
            'published_news' => News::published()->count(),
            'events_count' => Event::count(),
            'upcoming_events' => Event::upcoming()->count(),
            'groups_count' => Group::active()->count(),
            'masses_count' => Mass::active()->count(),
            'users_count' => User::count(),
        ];
        
        $recent_news = News::with('user')->latest()->take(5)->get();
        $upcoming_events = Event::with('user')->upcoming()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recent_news', 'upcoming_events'));
    }
}
