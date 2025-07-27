<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendaceAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $today = now()->toDateString();
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $stats = [
            // Heures aujourd'hui
            'today' => Attendance::whereDate('date', $today)
                ->sum('worked_hours'),

            // Heures cette semaine
            'week' => Attendance::whereBetween('date', [$weekStart, $weekEnd])
                ->sum('worked_hours'),

            // Heures ce mois
            'month' => Attendance::whereBetween('date', [$monthStart, $monthEnd])
                ->sum('worked_hours'),

            // Heures supplémentaires
            'overtime' => Attendance::where('user_id', 1)
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('overtime_hours'),

            // Heures productives aujourd’hui
            'productive_today' => Attendance::whereDate('date', $today)
                ->sum('productive_hours'),

            // Pauses aujourd’hui
            'break_today' => Attendance::whereDate('date', $today)
                ->sum('break_minutes') / 60, // en heures
        ];

        // Exemple de structure vide : 06h à 23h
        $timeline = [];
        for ($hour = 6; $hour <= 23; $hour++) {
            $timeline[$hour] = [
                'productive' => 0,
                'break' => 0,
                'overtime' => 0,
            ];
        }

        // Récupérer les données du jour
        $attendances = Attendance::whereDate('date', $today)
            ->get();

        foreach ($attendances as $att) {
            $start = Carbon::parse($att->punch_in_time);
            $end = Carbon::parse($att->punch_out_time ?? now());

            for ($hour = $start->hour; $hour <= $end->hour; $hour++) {
                if (isset($timeline[$hour])) {
                    $timeline[$hour]['productive'] += $att->productive_hours / ($end->hour - $start->hour + 1);
                    $timeline[$hour]['break'] += $att->break_minutes / 60 / ($end->hour - $start->hour + 1);
                    $timeline[$hour]['overtime'] += $att->overtime_hours / ($end->hour - $start->hour + 1);
                }
            }
        }

        $states = [
            'working' => $attendances->sum('worked_hours'),
            'productive' => $attendances->sum('productive_hours'),
            'break' => $attendances->sum('break_minutes') / 60,
            'overtime' => $attendances->sum('overtime_hours'),
            'timeline' => $timeline,
        ];

        $attendance = Attendance::all();

        $heureLimite = Carbon::createFromTime(9, 0, 0); // Limite pour considérer un "retard"

        // Liste des utilisateurs
        $totalUsers = User::count();

        // Présents aujourd'hui
        $presentToday = Attendance::whereDate('date', $today)->distinct('user_id')->count('user_id');

        // Retardataires
        $lateLogin = Attendance::whereDate('date', $today)
            ->whereTime('punch_in_time', '>', $heureLimite)
            ->distinct('user_id')
            ->count('user_id');

        // Absents = total - présents
        $absentToday = $totalUsers - $presentToday;

        $presenceDetails = [
            'present' => $presentToday,
            'late' => $lateLogin,
            'absent' => $absentToday,
        ];

        return view('hrm.attendance.attendance-admin', compact('stats', 'states', 'attendance', 'presenceDetails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
