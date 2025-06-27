<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\TrainersController;
use App\Http\Controllers\TrainingTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


//error
Route::fallback(function () {
    return response()->view('errors.error-404', [], 404);
});

// Dashboard
Route::get('employee-dashboard', function () {
    return view('dashboard.entreprises.employee-dashboard');
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

// Applications
Route::get('calendar', function () {
    return view('applications.calendar');
});

//CRM
Route::get('activity', function () {
    return view('crm.activity');
});


//Assets
Route::get('assetes', function () {
    return view('assets.assets');
});
Route::get('asset-categories', function () {
    return view('assets.asset-categories');
});

//Users Management
Route::get('users', function () {
    return view('roles.users');
});
Route::get('roles-permissions', function () {
    return view('roles.roles-permissions');
});

//Repports
Route::get('attendance-report', function () {
    return view('reports.attendance-report');
});
Route::get('daily-report', function () {
    return view('reports.daily-report');
});
Route::get('leave-report', function () {
    return view('reports.leave-report');
});
Route::get('employee-report', function () {
    return view('reports.employee-report');
});

// HRM
Route::resource('employees', EmployeesController::class);
Route::get('employee-details', function () {
    return view('hrm.employees.employee-details');
});
Route::resource('departments', DepartmentController::class);
Route::resource('designations', DesignationController::class);
Route::get('policy', function () {
    return view('hrm.employees.policy');
});
Route::get('tickets', function () {
    return view('hrm.tickets.tickets');
});
Route::get('ticket-details', function () {
    return view('hrm.tickets.ticket-details');
});
Route::resource('holidays', HolidaysController::class);
Route::get('leaves', function () {
    return view('hrm.attendances.leaves');
});
Route::get('leaves-employee', function () {
    return view('hrm.attendances.leaves-employee');
});
Route::get('leave-settings', function () {
    return view('hrm.attendances.leave-settings');
});
Route::get('attendance-admin', function () {
    return view('hrm.attendances.attendance-admin');
});
Route::get('attendance-employee', function () {
    return view('hrm.attendances.attendance-employee');
});
Route::get('timesheets', function () {
    return view('hrm.attendances.timesheets');
});
Route::get('schedule-timing', function () {
    return view('hrm.attendances.schedule-timing');
});
Route::get('overtime', function () {
    return view('hrm.attendances.overtime');
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
Route::get('training', function () {
    return view('hrm.trainings.training');
});
Route::resource('trainers', TrainersController::class);
Route::resource('training-type', TrainingTypeController::class);
Route::get('promotion', function () {
    return view('hrm.promotions.promotion');
});
Route::get('resignation', function () {
    return view('hrm.resignations.resignation');
});
Route::get('termination', function () {
    return view('hrm.terminations.termination');
});

