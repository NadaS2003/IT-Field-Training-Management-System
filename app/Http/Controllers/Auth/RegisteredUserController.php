<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function createSupervisor()
    {
        return view('register.supervisorReg');
    }

    public function storeSupervisor(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_id' => ['required', 'string', 'unique:supervisors'],
            'department' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string'],
            'password' => ['required', Rules\Password::defaults()],
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'employee_id.required' => 'حقل رقم الوظيفي مطلوب.',
            'employee_id.string' => 'يجب أن يكون رقم الوظيفي نصًا.',
            'employee_id.unique' => 'رقم الوظيفي مستخدم بالفعل.',

            'department.required' => 'حقل القسم مطلوب.',
            'department.string' => 'يجب أن يكون القسم نصًا.',

            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone_number.required' => 'حقل رقم الهاتف مطلوب.',
            'phone_number.string' => 'يجب أن يكون رقم الهاتف نصًا.',

            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'supervisor',
        ]);

        Supervisor::create([
            'full_name'=>$request->name,
            'user_id' => $user->id,
            'employee_id' => $request->employee_id,
            'department' => $request->department,
            'phone_number' => $request->phone_number,
        ]);

        auth()->login($user);

        return redirect()->route('supervisor.dashboard');
    }

    public function createCompany()
    {
        return view('register.companyReg');
    }


    public function storeCompany(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'website' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string'],
            'password' => ['required', Rules\Password::defaults()],
        ], [
            'name.required' => 'حقل اسم الشركة مطلوب.',
            'name.string' => 'يجب أن يكون اسم الشركة نصًا.',
            'name.max' => 'يجب ألا يتجاوز اسم الشركة 255 حرفًا.',

            'website.required' => 'حقل الموقع الإلكتروني مطلوب.',
            'website.string' => 'يجب أن يكون الموقع الإلكتروني نصًا.',

            'description.required' => 'حقل الوصف مطلوب.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',

            'location.required' => 'حقل الموقع مطلوب.',
            'location.string' => 'يجب أن يكون الموقع نصًا.',

            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone_number.required' => 'حقل رقم الهاتف مطلوب.',
            'phone_number.string' => 'يجب أن يكون رقم الهاتف نصًا.',

            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->all());
        }



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company',
        ]);

        Company::create([
            'company_name' => $request->name,
            'user_id' => $user->id,
            'website' => $request->website,
            'description' => $request->description,
            'location' => $request->location,
            'phone_number' => $request->phone_number,
        ]);

        auth()->login($user);

        return redirect()->route('company.dashboard');
    }

    public function createStudent()
    {
        return view('register.studentReg');
    }

    public function storeStudent(Request $request)
    {
         $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'university_id' => ['required', 'string', 'unique:students'],
            'major' => ['required', 'string'],
            'academic_year' => ['required', 'integer'],
            'gpa' => ['required', 'numeric'],
            'cv_file' => ['required', 'file', 'mimes:pdf,doc,docx'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string'],
            'password' => ['required', Rules\Password::defaults()],
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',

            'university_id.required' => 'حقل رقم الجامعي مطلوب.',
            'university_id.string' => 'يجب أن يكون رقم الجامعي نصًا.',
            'university_id.unique' => 'رقم الجامعي مستخدم بالفعل.',

            'major.required' => 'حقل التخصص مطلوب.',
            'major.string' => 'يجب أن يكون التخصص نصًا.',

            'academic_year.required' => 'حقل السنة الدراسية مطلوب.',
            'academic_year.integer' => 'يجب أن تكون السنة الدراسية رقمًا صحيحًا.',

            'gpa.required' => 'حقل المعدل التراكمي مطلوب.',
            'gpa.numeric' => 'يجب أن يكون المعدل التراكمي رقمًا.',

            'cv_file.required' => 'حقل ملف السيرة الذاتية مطلوب.',
            'cv_file.file' => 'يجب أن يكون ملف السيرة الذاتية ملفًا صالحًا.',
            'cv_file.mimes' => 'يجب أن يكون ملف السيرة الذاتية بصيغة PDF أو DOC أو DOCX.',

            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'phone_number.required' => 'حقل رقم الهاتف مطلوب.',
            'phone_number.string' => 'يجب أن يكون رقم الهاتف نصًا.',

            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->all());
        }


        $cvPath = $request->file('cv_file')->store('cv_files', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        Student::create([
            'full_name'=> $request->name,
            'user_id' => $user->id,
            'university_id' => $request->university_id,
            'major' => $request->major,
            'academic_year' => $request->academic_year,
            'cv_file' => $cvPath,
            'training_status' => 'Not started',
            'phone_number' => $request->phone_number,
            'gpa' => $request->gpa,
        ]);

        auth()->login($user);

        return redirect()->route('student.dashboard');
    }


}
