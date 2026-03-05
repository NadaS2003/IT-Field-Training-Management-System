<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Evaluation;
use App\Models\Student;
use App\Models\WeeklyEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{

    public function index()
    {
        $students = Student::whereHas('applications', function ($query) {
            $query->where('status', 'مقبول')
                ->where('admin_approval', 1)
                ->where('company_id', Auth::user()->company->id);
        })->get();

        $company_id = auth()->user()->company->id;

        $attendanceData = Attendance::where('company_id', $company_id)->distinct()->get();

        $evaluations = WeeklyEvaluation::where('company_id', $company_id)
            ->with('student')
            ->get();

        $weeks = WeeklyEvaluation::where('company_id', $company_id)
            ->distinct()
            ->pluck('week_name')
            ->sort()
            ->values();

        return view('company.reportsAndRates', compact('students', 'attendanceData', 'evaluations', 'weeks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'attendance_status' => 'required|in:حاضر,غائب',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $company_id = auth()->user()->company->id;

        $existingAttendance = Attendance::where('student_id', $request->student_id)
            ->where('date', $request->attendance_date)
            ->where('company_id', $company_id)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'الطالب قد سجل حضوره في نفس التاريخ مسبقًا.');
        }

        Attendance::create([
            'student_id' => $request->student_id,
            'company_id' => $company_id,
            'date' => $request->attendance_date,
            'status' => $request->attendance_status,
        ]);

        return redirect()->back()->with('success', 'تم التسجيل بنجاح');
    }

    public function exportToExcel()
    {
        $company_id = auth()->user()->company->id;
        return Excel::download(new AttendanceExport($company_id), 'attendance.xlsx');
    }


    public function update(Request $request, $attendanceId)
    {
        $request->validate([
            'status' => 'required|string|in:حاضر,غائب',
        ]);

        $attendance = Attendance::findOrFail($attendanceId);
        $attendance->status = $request->status;
        $attendance->save();

        return redirect()->back()->with('success', 'تم تحديث الحالة بنجاح.');
    }




}
