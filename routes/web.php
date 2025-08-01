<?php

use App\Http\Controllers\AttendaceAdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\IncenditController;
use App\Http\Controllers\LeavesAdminController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\TrainersController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingTypeController;
use App\Http\Controllers\UsersController;
use App\Models\Attendance;
use App\Models\Holidays;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('index', [CustomAuthController::class, 'dashboard']);
Route::post('custom-login', [CustomAuthController::class, 'customLogin']);
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('index');
    }
    return view('auth.login');
});

//error
Route::fallback(function () {
    return response()->view('errors.error-404', [], 404);
});

// Dashboard
Route::get('employee-dashboard', function () {
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
});

//Profile
Route::get('profile', function () {
    return view('profile.profile');
});
Route::get('profile-settings', function () {
    return view('profile.profile-settings');
});
Route::get('security-settings', function () {
    return view('profile.security-settings');
});
Route::get('notification-settings', function () {
    return view('profile.notification-settings');
});
Route::get('connected-apps', function () {
    return view('profile.connected-apps');
});
Route::get('bussiness-settings', function () {
    return view('profile.bussiness-settings');
});
Route::get('seo-settings', function () {
    return view('profile.seo-settings');
});
Route::get('prefixes', function () {
    return view('profile.prefixes');
});
Route::get('preferences', function () {
    return view('profile.preferences');
});
Route::get('currencies', function () {
    return view('profile.currencies');
});
Route::get('tax-rates', function () {
    return view('profile.tax-rates');
});
Route::get('payment-gateways', function () {
    return view('profile.payment-gateways');
});
Route::get('sms-settings', function () {
    return view('profile.sms-settings');
});
Route::get('sms-template', function () {
    return view('profile.sms-template');
});
Route::get('email-template', function () {
    return view('profile.email-template');
});
Route::get('email-settings', function () {
    return view('profile.email-settings');
});
Route::get('leave-type', function () {
    return view('profile.leave-type');
});

//CRM
Route::get('activity', function () {
    return view('admin.help.activity');
});


//Assets
Route::get('assetes', function () {
    return view('admin.assets.assets');
});
Route::get('asset-categories', function () {
    return view('admin.assets.asset-categories');
});

//Users Management
Route::resource('users', UsersController::class);
Route::get('roles-permissions', function () {
    return view('admin.user.roles-permissions');
});

//Repports
Route::get('attendance-report', function () {
    return view('admin.reports.attendance-report');
});
Route::get('daily-report', function () {
    return view('admin.reports.daily-report');
});
Route::get('leave-report', function () {
    return view('admin.reports.leave-report');
});
Route::get('employee-report', function () {
    return view('admin.reports.employee-report');
});

// HRM
Route::resource('evaluations', EvaluationController::class);
Route::resource('employees', EmployeesController::class);
Route::post('add-bank/{id}', [EmployeesController::class, 'bank']);

Route::post('add-famille/{id}', [EmployeesController::class, 'famille']);

Route::post('add-education/{id}', [EmployeesController::class, 'education']);
Route::post('edit-education/{id}', [EmployeesController::class, 'updateEducation']);
Route::delete('/delete-education/{id}', [EmployeesController::class, 'deleteEducation']);

Route::post('add-experience/{id}', [EmployeesController::class, 'experience']);
Route::post('edit-experience/{id}', [EmployeesController::class, 'updateExperience']);
Route::delete('/delete-experience/{id}', [EmployeesController::class, 'deleteExperience']);

Route::post('add-urgence/{id}', [EmployeesController::class, 'urgence']);

Route::get('get-designations/{departement_id}', [EmployeesController::class, 'getDesignations']);
Route::get('employee-details', function () {
    return view('hrm.employees.employee-details');
});
Route::resource('departments', DepartmentController::class);
Route::resource('designations', DesignationController::class);
Route::resource('policy', PolicyController::class);
Route::get('tickets', function () {
    return view('hrm.tickets.tickets');
});
Route::get('ticket-details', function () {
    return view('hrm.tickets.ticket-details');
});
Route::resource('holidays', HolidaysController::class);
Route::get('leave-settings', function () {
    return view('hrm.attendance.leaves.leave-settings');
});
Route::resource('leaves', LeavesAdminController::class);
Route::resource('leaves-employee', LeavesController::class);
Route::resource('attendance-admin', AttendaceAdminController::class);
Route::resource('attendance-employee', AttendanceController::class);
Route::resource('attendance-incendit', IncenditController::class);
Route::get('timesheets', function () {
    return view('hrm.attendance.timesheets');
});
Route::get('schedule-timing', function () {
    return view('hrm.attendance.schedule-timing');
});
Route::get('overtime', function () {
    return view('hrm.attendance.overtime');
});
Route::get('performance-indicator', function () {
    return view('hrm.performance.performance-indicator');
});
Route::get('performance-review', function () {
    return view('hrm.performance.performance-review');
});
Route::get('performance-appraisal', function () {
    return view('hrm.performance.performance-appraisal');
});
Route::get('goal-tracking', function () {
    return view('hrm.performance.goal-tracking');
});
Route::get('goal-type', function () {
    return view('hrm.performance.goal-type');
});
Route::get('/attendance/timeline', [AttendanceController::class, 'loadTimeline'])->name('attendance.timeline');
//Route::middleware(['auth'])->group(function () {
Route::post('/attendance/punch', [AttendanceController::class, 'storePunch'])->name('attendance.punch');
//});
Route::resource('training', TrainingController::class);
Route::resource('trainers', TrainersController::class);
Route::resource('training-type', TrainingTypeController::class);
Route::resource('promotion', PromotionController::class);
Route::resource('resignation', ResignationController::class);
Route::resource('termination', TerminationController::class);
