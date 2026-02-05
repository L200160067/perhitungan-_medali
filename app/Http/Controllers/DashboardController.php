<?php

namespace App\Http\Controllers;

use App\Models\Contingent;
use App\Models\Dojang;
use App\Models\Event;
use App\Models\Medal;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $totalDojangs = Dojang::count();
        $totalParticipants = Participant::count();
        $totalRegistrations = Registration::count();

        // Medal standings - group by contingent
        $medalStandings = Contingent::query()
            ->select('contingents.*')
            ->selectRaw('
                SUM(CASE WHEN medals.name = "gold" THEN 1 ELSE 0 END) as gold_count,
                SUM(CASE WHEN medals.name = "silver" THEN 1 ELSE 0 END) as silver_count,
                SUM(CASE WHEN medals.name = "bronze" THEN 1 ELSE 0 END) as bronze_count,
                COUNT(registrations.medal_id) as total_medals
            ')
            ->leftJoin('registrations', 'contingents.id', '=', 'registrations.contingent_id')
            ->leftJoin('medals', 'registrations.medal_id', '=', 'medals.id')
            ->groupBy('contingents.id', 'contingents.name', 'contingents.event_id', 'contingents.dojang_id', 'contingents.created_at', 'contingents.updated_at')
            ->having('total_medals', '>', 0)
            ->orderByDesc('gold_count')
            ->orderByDesc('silver_count')
            ->orderByDesc('bronze_count')
            ->get();

        return view('dashboard', compact(
            'totalEvents',
            'totalDojangs',
            'totalParticipants',
            'totalRegistrations',
            'medalStandings'
        ));
    }
}
