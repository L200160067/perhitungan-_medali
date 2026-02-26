<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        $stats = $this->dashboardService->getStats();
        $events = $this->dashboardService->getEvents();

        // Determine active event ID (from request or the most recent one)
        $activeEventId = $request->input('event_id');
        if (! $activeEventId && $events->isNotEmpty()) {
            $activeEventId = $events->first()->id;
        }

        $activeEvent = $events->find($activeEventId);
        $medalStandings = $this->dashboardService->getMedalStandings($activeEventId);

        return view('dashboard', array_merge($stats, compact(
            'events',
            'activeEventId',
            'activeEvent',
            'medalStandings'
        )));
    }
}
