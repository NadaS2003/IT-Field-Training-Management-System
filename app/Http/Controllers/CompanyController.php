<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Attendance;
use App\Models\Internship;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function dashboard()
    {

        $notifications = auth()->user()->company->notifications()->whereNull('read_at')->get();

        return view('company.dashboard', compact('notifications'));
    }

    public function index()
    {
        $company_id = Auth::user()->company->id;
        $internshipsCount = Internship::query()->where('company_id', '=', $company_id)->get()->count();
        $applicationCount = Application::query()->where('company_id',$company_id)->where('status','مقبول')
            ->get()->count();
        $applicationPendingCount = Application::query()->where('company_id',$company_id)
            ->where('status','قيد المراجعة')
            ->get()->count();
        $attendanceData = Attendance::selectRaw('status, COUNT(*) as count')
            ->where('company_id', '=', $company_id)
            ->groupBy('status')
            ->get();

        $attendanceCounts = [
            'حاضر' => 0,
            'غائب' => 0,
        ];

        foreach ($attendanceData as $data) {
            if ($data->status == 'حاضر') {
                $attendanceCounts['حاضر'] = $data->count;
            } elseif ($data->status == 'غائب') {
                $attendanceCounts['غائب'] = $data->count;
            }
        }

        $studentsPerOpportunity = DB::table('internships')
            ->select(
                'internships.title',
                DB::raw('COUNT(CASE WHEN applications.status = "مقبول" AND applications.admin_approval = 1 THEN applications.student_id END) as student_count')
            )
            ->leftJoin('applications', 'internships.id', '=', 'applications.internship_id')
            ->where('internships.status', '=', 'مفتوحة')
            ->where('internships.company_id', '=', $company_id) // تصفية النتائج حسب الشركة
            ->groupBy('internships.title')
            ->get();

        $labels = $studentsPerOpportunity->pluck('title');
        $studentCounts = $studentsPerOpportunity->pluck('student_count')->map(fn($count) => $count ?: 0);

        return view('company.dashboard', compact('internshipsCount', 'attendanceCounts','labels',
            'studentCounts','applicationCount','applicationPendingCount'));
    }


    public function showInternships()
    {
        $company_id = Auth::user()->company->id;

        $internships = Internship::query()->where('company_id','=',$company_id)->paginate(10);

        return view('company.showInternships',compact('internships'));
    }

    public function showTrainingReq()
    {
        $company_id = Auth::user()->company->id;

        $applications = Application::query()->where('company_id','=',$company_id)->paginate(10);

        return view('company.trainingRequests',compact('applications'));
    }

    public function approvedStudents(){
        $company_id = Auth::user()->company->id;
        $approvedStudents = Application::where('status', 'مقبول')
            ->where('admin_approval', 1)
            ->where('company_id',$company_id)
            ->with('student', 'internship')
            ->get();

        return view('company.approved_students', compact('approvedStudents'));
    }

}
