@extends('layouts.admin')
@section('content')
    <main class="flex-1 bg-[#f8fafc] min-h-screen  text-right" dir="rtl">

        <header class="mb-10 px-2">
            <h1 class="text-2xl font-black text-gray-800 tracking-tight ">إدارة الطلبات التدريبية</h1>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">مرحباً بك، يمكنك إضافة ومراقبة كافة طلبات التدريب المقدمة من الطلاب.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">إجمالي الطلبات</span>
                    <span class="text-3xl font-black text-gray-800 tracking-tighter ">{{ \App\Models\Application::count()}}</span>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-list-ul text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">طلبات مكتملة</span>
                    <span class="text-3xl font-black text-green-600 tracking-tighter ">{{ \App\Models\Application::whereIn('status', ['مقبول', 'مرفوض'])->count() }}</span>
                </div>
                <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-green-100 transition-colors">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2.2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-white flex items-center justify-between transition-all hover:shadow-[0_15px_35px_rgba(0,0,0,0.06)] group">
                <div class="flex flex-col">
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">قيد المراجعة</span>
                    <span class="text-3xl font-black text-orange-400 tracking-tighter ">{{ \App\Models\Application::where('status', 'قيد المراجعة')->count()}}</span>
                </div>
                <div class="w-14 h-14 bg-orange-50 text-orange-400 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-orange-100 transition-colors">
                    <i class="fas fa-hourglass-half text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4 px-2">
            <h3 class="font-black text-xl text-gray-800 ">قائمة الطلبات الأخيرة</h3>
            <form action="{{ route('admin.trainingRequests') }}" method="GET" class="flex gap-3 w-full md:w-auto">
                <div class="relative flex-1 group">
                    <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text" name="search"
                           class="w-full md:w-72 bg-white border border-gray-100 pr-11 pl-4 py-3 rounded-2xl text-xs font-bold text-gray-700 shadow-inner focus:ring-4 focus:ring-blue-50/50 outline-none transition-all"
                           placeholder="البحث باسم الطالب..."
                           value="{{ request()->get('search') }}">
                </div>
                <button class="bg-[#0076df] text-white px-8 py-3 rounded-2xl font-black text-xs shadow-[0_12px_25px_rgba(0,118,223,0.2)] hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95" type="submit">بحث</button>
            </form>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.1em] bg-gray-50/30">
                        <th class="px-8 py-7">الطالب</th>
                        <th class="px-8 py-7">جهة التدريب</th>
                        <th class="px-8 py-7 text-center">تاريخ الطلب</th>
                        <th class="px-8 py-7 text-center">الحالة</th>
                        <th class="px-8 py-7 text-left">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($trainingRequests as $trainingRequest)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-8 py-7">
                                <span class="text-gray-800 font-black group-hover:text-blue-600 transition-colors">{{$trainingRequest->student->full_name}}</span>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-xs font-bold text-gray-600  ">{{$trainingRequest->company->company_name}}</span>
                            </td>
                            <td class="px-8 py-7 text-center">
                            <span class="text-[10px] font-black text-gray-400 bg-gray-50 px-3 py-1 rounded-lg border border-gray-100 shadow-inner ">
                                {{$trainingRequest->created_at->format('d-m-Y')}}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $statusStyles = match($trainingRequest->status) {
                                        'مقبول' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-100'],
                                        'قيد المراجعة' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'border' => 'border-orange-100'],
                                        'مرفوض' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-100'],
                                        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-400', 'border' => 'border-gray-200'],
                                    };
                                @endphp
                                <span class="{{ $statusStyles['bg'] }} {{ $statusStyles['text'] }} {{ $statusStyles['border'] }} px-5 py-1.5 rounded-xl text-[10px] font-black shadow-sm border inline-flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-current {{ $trainingRequest->status == 'قيد المراجعة' ? 'animate-pulse' : '' }}"></span>
                                {{ $trainingRequest->status }}
                            </span>
                            </td>
                            <td class="px-8 py-7 text-left">
                                @if($trainingRequest->status == 'مقبول' && $trainingRequest->admin_approval == 0)
                                    <div class="flex gap-2 justify-end">
                                        <button onclick="updateApproval({{ $trainingRequest->id }}, 1)" class="w-10 h-10 flex items-center justify-center bg-white border border-green-100 text-green-500 rounded-xl shadow-sm hover:bg-green-500 hover:text-white transition-all active:scale-90 shadow-inner">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                        <button onclick="updateApproval({{ $trainingRequest->id }}, -1)" class="w-10 h-10 flex items-center justify-center bg-white border border-red-100 text-red-500 rounded-xl shadow-sm hover:bg-red-500 hover:text-white transition-all active:scale-90 shadow-inner">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-[10px] font-black text-gray-400  bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100/50">
                                    @if($trainingRequest->admin_approval == 1) <i class="fas fa-check-double text-green-500 ml-1"></i> تم القبول النهائي
                                        @elseif($trainingRequest->admin_approval == -1) <i class="fas fa-ban text-red-400 ml-1"></i> مرفوض من الإدارة
                                        @else <i class="far fa-clock ml-1"></i> بانتظار رد الشركة
                                        @endif
                                </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-4 shadow-inner text-gray-200 text-3xl">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <p class="text-gray-400 font-black ">لا توجد طلبات تدريب متاحة حالياً.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 border-t border-gray-50 flex justify-between items-center bg-white">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]"> عرض <span class="text-gray-800 ">{{ $trainingRequests->count() }}</span> من أصل <span class="text-gray-800 ">{{ $trainingRequests->total() }}</span> طلب</p>
                @if($trainingRequests->hasPages())
                    <div class="bg-gray-50/50 px-4 py-1 rounded-2xl shadow-inner border border-gray-100">
                        {{ $trainingRequests->links('vendor.pagination.simple-tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateApproval(requestId, approvalStatus) {
            $.ajax({
                url: "{{ route('admin.updateApproval', ':id') }}".replace(':id', requestId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    admin_approval: approvalStatus
                },
                success: function (response) {
                    if (response.success) { location.reload(); }
                }
            });
        }
    </script>
@endsection
