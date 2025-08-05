<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Departments;
use App\Models\Holidays;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $roles = [
            'email' => 'required',
            'password' => 'required',
        ];
        $customMessages = [
            'email.required' => "Veuillez saisir son adresse email.",
            'password.required' => "Veuillez saisir son mot de passe.",
        ];

        $request->validate($roles, $customMessages);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            if ($user->statut == 'Active') {
                Auth::login($user);
                return redirect()->intended('index');
            } else {
                return back()->withErrors(['Votre compte est désactivé. Veuillez contacter l\'administrateur.']);
            }
        } else {
            return back()->withErrors(['E-mail ou mot de passe incorrect.']);
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Resporh') {

                $active = User::where('statut', '=', 'Active')
                    ->where('type_recru', '=', 'Recruter')
                    ->count();
                $inactive = User::where('statut', '=', 'Inactive')
                    ->where('type_recru', '=', 'Recruter')
                    ->count();
                $encours = User::where('type_recru', '=', 'Encours')
                    ->count();
                $department = Departments::where('status_depart', '=', 'Active')
                    ->count();
                $employes = User::join('departments', 'users.department_id', '=', 'departments.depart')
                    ->select('users.name', 'users.last_name', 'departments.deparment_name as department_name')
                    ->limit(5)
                    ->get();

                $data = User::join('departments', 'users.department_id', '=', 'departments.depart')
                    ->select('departments.deparment_name as department', DB::raw('COUNT(users.id) as total'))
                    ->groupBy('departments.deparment_name')
                    ->get();

                // Extraire les données dans deux tableaux distincts
                $counts = $data->pluck('total');
                $departments = $data->pluck('department');

                $today = Carbon::today()->format('d-m');
                $tomorrow = Carbon::tomorrow()->format('d-m');

                // 🎂 Anniversaires aujourd'hui
                $todayBirthdays = User::join('designations', 'users.designation_id', '=', 'designations.design')
                    ->select('users.*', 'designations.name_designation')
                    ->whereRaw("DATE_FORMAT(STR_TO_DATE(date_naissance, '%d-%m-%Y'), '%d-%m') = ?", [$today])
                    ->get();

                // 🎂 Anniversaires demain
                $tomorrowBirthdays = User::join('designations', 'users.designation_id', '=', 'designations.design')
                    ->select('users.*', 'designations.name_designation')
                    ->whereRaw("DATE_FORMAT(STR_TO_DATE(date_naissance, '%d-%m-%Y'), '%d-%m') = ?", [$tomorrow])
                    ->get();

                // 🎂 Anniversaires à venir après demain
                $upcomingBirthdays = User::join('designations', 'users.designation_id', '=', 'designations.design')
                    ->select('users.*', 'designations.name_designation')
                    ->whereRaw("STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', DATE_FORMAT(STR_TO_DATE(date_naissance, '%d-%m-%Y'), '%m-%d')), '%Y-%m-%d') > CURDATE()")
                    ->orderByRaw("DATE_FORMAT(STR_TO_DATE(date_naissance, '%d-%m-%Y'), '%m-%d')")
                    ->get();

                return view('dashboard.index', compact(
                    'active',
                    'inactive',
                    'department',
                    'encours',
                    'employes',
                    'counts',
                    'departments',
                    'todayBirthdays',
                    'tomorrowBirthdays',
                    'upcomingBirthdays'
                ));
            } else {
                $membres = User::join('departments', 'users.department_id', '=', 'departments.depart')
                    ->where('users.department_id', Auth::user()->department_id)
                    ->select('users.name', 'users.last_name', 'users.photo', 'departments.deparment_name as department_name')
                    ->get();

                $today = Carbon::today()->format('d-m');

                // 🎂 Anniversaires aujourd'hui
                $todayBirthdays = User::join('designations', 'users.designation_id', '=', 'designations.design')
                    ->select('users.name', 'users.last_name', 'designations.name_designation')
                    ->whereRaw("DATE_FORMAT(STR_TO_DATE(date_naissance, '%d-%m-%Y'), '%d-%m') = ?", [$today])
                    ->inRandomOrder()
                    ->first();

                $nextHoliday = Holidays::whereDate('date', '>=', Carbon::today())
                    ->orderBy('date', 'asc')
                    ->first();

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

                return view('dashboard.employee-dashboard', compact('membres', 'todayBirthdays', 'nextHoliday', 'stats', 'states'));
            }
        } else {
            return view('auth.login');
        }
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
