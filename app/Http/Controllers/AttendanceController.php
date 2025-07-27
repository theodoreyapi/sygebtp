<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $user = Auth::user();

        $today = now()->toDateString();
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $stats = [
            // Heures aujourd'hui
            'today' => Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->sum('worked_hours'),

            // Heures cette semaine
            'week' => Attendance::where('user_id', $user->id)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->sum('worked_hours'),

            // Heures ce mois
            'month' => Attendance::where('user_id', $user->id)
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('worked_hours'),

            // Heures supplémentaires
            'overtime' => Attendance::where('user_id', $user->id)
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('overtime_hours'),

            // Heures productives aujourd’hui
            'productive_today' => Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->sum('productive_hours'),

            // Pauses aujourd’hui
            'break_today' => Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
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
        $attendances = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
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

        $attendance = Attendance::where('user_id', $user->id)
            ->get();

        return view('hrm.attendance.attendance-employee', compact('stats', 'states', 'attendance'));
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

    public function loadTimeline(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date', now()->toDateString());

        $timeline = [];
        for ($hour = 6; $hour <= 23; $hour++) {
            $timeline[$hour] = [
                'productive' => 0,
                'break' => 0,
                'overtime' => 0,
            ];
        }

        $attendances = Attendance::where('user_id', $user->id)
            ->whereDate('date', $date)
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

        return response()->json($timeline);
    }

    public function storePunch(Request $request)
    {
        $userId = Auth::user()->id; // Remplace par auth()->id() quand l'auth est prête
        $today = now()->toDateString();

        $attendance = Attendance::firstOrNew([
            'user_id' => $userId,
            'date' => $today,
        ]);

        // Punch In
        if (is_null($attendance->punch_in_time)) {
            $attendance->punch_in_time = now();
            $attendance->status = 'Present';
            $message = 'Punch In effectué à ' . $attendance->punch_in_time->format('H:i');
        }
        // Punch Out
        elseif (is_null($attendance->punch_out_time)) {
            $attendance->punch_out_time = now();

            // Convertir manuellement les champs si nécessaires
            $in = Carbon::parse($attendance->punch_in_time);
            $out = Carbon::parse($attendance->punch_out_time);

            $workedSeconds = $out->diffInSeconds($in);
            $workedHours = $workedSeconds / 3600;

            $attendance->worked_hours = round($workedHours, 2);
            $attendance->break_minutes = 60;
            $attendance->productive_hours = round($workedHours - 1, 2);
            $attendance->overtime_hours = max(0, $workedHours - 8);

            $message = 'Punch Out effectué à ' . $attendance->punch_out_time->format('H:i');
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous avez déjà pointé In et Out pour aujourd’hui.',
            ], 400);
        }

        $attendance->save();

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'punch_in' => optional($attendance->punch_in_time)->format('H:i'),
                'punch_out' => optional($attendance->punch_out_time)->format('H:i'),
                'worked_hours' => $attendance->worked_hours,
                'productive_hours' => $attendance->productive_hours,
                'break_minutes' => $attendance->break_minutes,
                'overtime_hours' => $attendance->overtime_hours,
            ]
        ]);
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
