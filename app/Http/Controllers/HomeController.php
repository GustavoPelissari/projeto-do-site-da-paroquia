<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Mass;
use App\Models\Event;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // Buscar grupos e missas para a home
        $groups = Group::active()->take(6)->get();
        $masses = Mass::orderBy('day_of_week')->orderBy('time')->get();
        $recentSchedules = Schedule::latest()->take(3)->get();
        
        return view('home', compact('groups', 'masses', 'recentSchedules'));
    }
    
    public function groups()
    {
        $groups = Group::orderBy('name')->get();
        return view('groups', compact('groups'));
    }
    
    public function masses()
    {
        $masses = Mass::orderBy('day_of_week')->orderBy('time')->get();
        return view('masses', compact('masses'));
    }
    
    public function events()
    {
        $events = Event::where('start_date', '>=', now())
                      ->orderBy('start_date')
                      ->paginate(12);
        return view('events', compact('events'));
    }
    
    public function news()
    {
        $news = News::latest()->paginate(10);
        return view('news', compact('news'));
    }
}
