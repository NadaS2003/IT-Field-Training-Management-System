<?php

namespace App\Http\Controllers;

use App\Exports\EvaluationExport;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'training_book' => 'required|file|mimes:pdf,docx,doc|max:2048',
        ], [
            'student_id.required' => 'يجب اختيار الطالب.',
            'student_id.exists' => 'الطالب المحدد غير موجود في قاعدة البيانات.',
            'training_book.required' => 'يجب تحميل كتاب التدريب.',
            'training_book.file' => 'يجب أن يكون الملف من نوع ملف.',
            'training_book.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOCX أو DOC.',
            'training_book.max' => 'حجم الملف يجب أن لا يتجاوز 2 ميجابايت.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $company_id = Auth::user()->company->id;


        $filename = $request->file('training_book')->store('public/training_books');
        $storedFilename = str_replace('public/', '', $filename);

        Evaluation::updateOrCreate(
            ['student_id' => $request->student_id],
            [
                'company_id' => $company_id,
                'evaluation_letter' => $storedFilename
            ]
        );

        return back()->with('success', 'تم رفع الكتاب بنجاح!');
    }


}
