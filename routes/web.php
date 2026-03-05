<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\WeeklyEvaluationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('splash');
});
###############################################################################################################
Route::get('/loginAll', function () {
    return view('Login.login');
})->name('loginAll');
Route::get('/superLogin', function () {
    return view('Login.supervisorLogin');
});
Route::get('/studentLogin', function () {
    return view('Login.studentLogin');
});
Route::get('/companyLogin', function () {
    return view('Login.companyLogin');
});
Route::get('/adminLogin', function () {
    return view('Login.adminLogin');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');

###############################################################################################################3
Route::get('/registerAll', function () {
    return view('register.register');
})->name('registerAll');
Route::get('/superReg', function () {
    return view('register.supervisorReg');
});
Route::get('/studentReg', function () {
    return view('register.studentReg');
});
Route::get('/companyReg', function () {
    return view('register.companyReg');
});

Route::get('/register/supervisor', [RegisteredUserController::class, 'createSupervisor'])->name('register.supervisor');
Route::post('/register/supervisor', [RegisteredUserController::class, 'storeSupervisor'])->name('register.supervisor.store');

Route::get('/register/company', [RegisteredUserController::class, 'createCompany'])->name('register.company');
Route::post('/register/company', [RegisteredUserController::class, 'storeCompany']);

Route::get('/register/student', [RegisteredUserController::class, 'createStudent'])->name('register.student');
Route::post('/register/student', [RegisteredUserController::class, 'storeStudent']);

####################################################  Student  ###########################################################3

Route::get('/studentDash',[studentController::class, 'index'])->name('student.dashboard')->middleware('role:student');
Route::get('/showTraining',[InternshipController::class, 'show'])->name('student.showTraining')->middleware('role:student');
Route::get('/OpportunityDetails/{id}',[InternshipController::class, 'opportunityDetails'])->name('student.opportunityDetails')->middleware('role:student');
Route::post('/applications/store',[ApplicationController::class,'store'])->name('applications.store')->middleware('role:student');
Route::get('/myRequests',[StudentController::class,'showApplications'])->name('student.myRequests')->middleware('role:student');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'showStudent'])->name('student.Profile');
    Route::put('/profile/update', [ProfileController::class, 'updateStudent'])->name('student.Profile.update');
})->middleware('role:student');
Route::post('/mark-notifications-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAllRead');

#########################################################  Supervsior  ######################################################3

Route::get('/supervisorDash',[SupervisorController::class,'index'])->name('supervisor.dashboard')->middleware('role:supervisor');
Route::get('/studentsList',[SupervisorController::class,'studentsList'])->name('supervisor.studentsList')->middleware('role:supervisor');
Route::get('/studentDetails/{id}',[SupervisorController::class,'studentDetails'])->name('supervisor.studentDetails')->middleware('role:supervisor');
Route::get('/companiesList',[SupervisorController::class,'companiesList'])->name('supervisor.companiesList')->middleware('role:supervisor');
Route::get('/rates',[SupervisorController::class,'showEvaluation'])->name('supervisor.rates')->middleware('role:supervisor');
Route::post('/rates/store',[SupervisorController::class,'storeEvaluation'])->name('supervisor.rates.store')->middleware('role:supervisor');
Route::get('/supervisor/export-evaluations', [SupervisorController::class, 'exportEvaluations'])->name('supervisor.export.evaluations');

#########################################################  Company  ######################################################3

Route::get('/companyDash',[CompanyController::class,'index'])->name('company.dashboard')->middleware('role:company');
Route::get('/companyTrainingRequests',[CompanyController::class,'showTrainingReq'])->name('company.trainingRequests')->middleware('role:company');
Route::post('/applications/{id}/update-status', [ApplicationController::class, 'updateStatus'])->middleware('role:company');
Route::get('/student_details/{id}', function ($id) {
    $application= \App\Models\Application::findOrFail($id);
    $student = \App\Models\Student::findOrFail($id);
    return view('company.student_detials', compact('application','student'));
})->name('company.studentDetails');
Route::get('/companyShowInternships',[CompanyController::class,'showInternships'])->name('company.showInternships')->middleware('role:company');
Route::post('/companyAddInternships',[InternshipController::class,'store'])->name('company.storeInternships')->middleware('role:company');
Route::put('/companyUpdateInternships/{id}',[InternshipController::class,'update'])->name('company.updateInternship')->middleware('role:company');
Route::delete('/company/deleteInternship/{id}', [InternshipController::class, 'destroy'])->name('company.deleteInternship');
Route::get('/companyReportsAndRates',[AttendanceController::class, 'index'])->name('company.reportsAndRates')->middleware('role:company');
Route::post('/upload-training-book', [EvaluationController::class, 'store'])->name('upload.store');
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::put('/attendance/{attendanceId}/update', [AttendanceController::class, 'update'])->name('attendance.update');
Route::get('/attendance/export', [AttendanceController::class, 'exportToExcel'])->name('attendance.export');
Route::post('/weekly_evaluations/store',[ WeeklyEvaluationController::class,'store'])->name('weekly_evaluations.store')->middleware('role:company');
Route::put('/update-weekly-evaluation/{id}', [WeeklyEvaluationController::class, 'update'])->name('weekly_evaluations.update');
Route::get('/export-evaluations', [WeeklyEvaluationController::class,'exportToExcel'])->name('export.evaluations');
Route::middleware(['auth'])->group(function () {
    Route::get('/companyProfile', [ProfileController::class, 'showCompany'])->name('company.profile');
    Route::put('/companyProfile/update', [ProfileController::class, 'updateCompany'])->name('company.profile.update');
})->middleware('role:company');
Route::post('/mark-notifications-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAllRead');
Route::get('/approved-students', [CompanyController::class, 'approvedStudents'])->name('company.approved_students');

#########################################################  Admin  ######################################################3

Route::get('/adminDash',[AdminController::class,'index'])->name('admin.dashboard')->middleware('role:admin');
Route::get('/studentsManagement',[AdminController::class,'showStudent'])->name('admin.studentsManagement')->middleware('role:admin');
Route::delete('/studentsManagement/{id}', [AdminController::class, 'destroyStudent'])->name('admin.destroyStudent')->middleware('role:admin');
Route::get('/supervisorsManagement',[AdminController::class,'showSupervisors'])->name('admin.supervisorsManagement')->middleware('role:admin');
Route::delete('/supervisorsManagement/{id}', [AdminController::class, 'destroySupervisor'])->name('admin.destroySupervisor')->middleware('role:admin');
Route::get('/companiesManagement',[AdminController::class,'showCompanies'])->name('admin.companiesManagement')->middleware('role:admin');
Route::delete('/companiesManagement/{id}', [AdminController::class, 'destroyCompany'])->name('admin.destroyCompany')->middleware('role:admin');
Route::get('/opportunitiesManagement',[AdminController::class,'showOpportunities'])->name('admin.opportunitiesManagement')->middleware('role:admin');
Route::get('/audienceManagement',[AdminController::class,'showAttendance'])->name('admin.audienceManagement')->middleware('role:admin');
Route::get('/audienceManagement/export',[AdminController::class,'exportAttendance'])->name('admin.attendance.export')->middleware('role:admin');
Route::get('/studentsRate',[AdminController::class,'showStudentsRates'])->name('admin.studentsRate')->middleware('role:admin');
Route::get('/admin/export-rates', [AdminController::class, 'exportRates'])->name('admin.exportRates')->middleware('role:admin');
Route::get('/trainingRequests',[AdminController::class,'trainingRequests'])->name('admin.trainingRequests')->middleware('role:admin');
Route::post('/update-approval/{id}', [AdminController::class, 'updateApproval'])->name('admin.updateApproval')->middleware('role:admin');
Route::get('/trainingBooks',[AdminController::class, 'showTrainingBooks'])->name('admin.trainingBooks')->middleware('role:admin');
Route::get('/studentsData',[AdminController::class, 'getStudentsAndSupervisors'])->name('admin.studentsData')->middleware('role:admin');
Route::post('/assign-supervisor', [AdminController::class, 'assignSupervisorToStudent'])->name('assign-supervisor')->middleware('role:admin');

###############################################################################################################3

require __DIR__.'/auth.php';
