@extends('layouts.company')
@section('title', 'إدارة الفرص التدريبية')
@section('content')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-input {
            background-color: #fcfdfe;
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .custom-input:focus {
            background-color: white;
            border-color: #0076df;
            box-shadow: 0 0 0 4px rgba(0, 118, 223, 0.08);
            outline: none;
        }
        .animate-fade-up {
            animation: fadeUp 0.5s ease-out forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <main class="flex-1 p-8 bg-[#f8fafc] min-h-screen text-right" dir="rtl">

        @if (session('success'))
            <script>Swal.fire({ icon: 'success', title: 'تم بنجاح', text: "{{ session('success') }}", confirmButtonColor: '#0076df' });</script>
        @endif

        <div class="flex justify-between items-center mb-10 px-2 animate-fade-up">
            <div class="text-right">
                <h1 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">إدارة الفرص التدريبية</h1>
                <p class="text-gray-500 font-medium text-sm ">تحكم في مسارات التدريب وحدث بياناتها بضغطة زر</p>
            </div>
            <button onclick="openModal('addModal')"
                    class="bg-[#0076df] text-white px-8 py-4 rounded-[1.5rem] font-black shadow-[0_10px_25px_rgba(0,118,223,0.25)] hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 flex items-center gap-3">
                <i class="fas fa-plus-circle"></i>
                <span>إضافة فرصة جديدة</span>
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-white overflow-hidden animate-fade-up">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white">
                <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                    <span class="w-2 h-7 bg-[#0076df] rounded-full shadow-sm"></span> قائمة المسارات الحالية
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="text-gray-400 text-[11px] font-black uppercase tracking-[0.15em] bg-gray-50/30">
                        <th class="px-8 py-6">مسمى الفرصة</th>
                        <th class="px-8 py-6 text-center">المدة</th>
                        <th class="px-8 py-6 text-center">النطاق الزمني</th>
                        <th class="px-8 py-6 text-center">حالة النشر</th>
                        <th class="px-8 py-6 text-center">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse ($internships as $internship)
                        <tr class="hover:bg-gray-50/40 transition-all group">
                            <td class="px-8 py-7">
                                <p class="font-black text-gray-800 text-sm group-hover:text-[#0076df] transition">{{ $internship->title }}</p>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <span class="bg-blue-50/50 text-[#0076df] px-4 py-1.5 rounded-xl text-xs font-black border border-blue-100/30 shadow-sm">
                                    {{ $internship->duration }} أشهر
                                </span>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <span class="text-[11px] font-black text-gray-500 ">{{ $internship->start_date }}</span>
                                    <div class="w-4 h-[1px] bg-gray-200"></div>
                                    <span class="text-[11px] font-black text-gray-400 ">{{ $internship->end_date }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black shadow-sm border
                                    {{ $internship->status == 'مفتوحة' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }}">
                                    {{ $internship->status }}
                                </span>
                            </td>
                            <td class="px-8 py-7">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditModal({{ json_encode($internship) }})"
                                            class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-white hover:shadow-lg rounded-2xl transition-all border border-transparent hover:border-blue-50">
                                        <i class="far fa-edit text-lg"></i>
                                    </button>

                                    <form action="{{ route('company.deleteInternship', $internship->id) }}" method="POST" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)"
                                                class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-white hover:shadow-lg rounded-2xl transition-all border border-transparent hover:border-red-50">
                                            <i class="far fa-trash-alt text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-300">
                                    <div class="w-24 h-24 bg-gray-50 rounded-[3rem] flex items-center justify-center mb-6 shadow-inner">
                                        <i class="fas fa-briefcase text-4xl opacity-20"></i>
                                    </div>
                                    <p class="font-black text-sm text-gray-400">لم تقم بإضافة أي فرص تدريبية بعد</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- المودالات (إضافة / تعديل) بنفس ستايل "Glassmorphism" المعتمد --}}
        <div id="addModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/40 backdrop-blur-md hidden p-4">
            <div class="bg-white rounded-[3rem] shadow-[0_30px_80px_rgba(0,0,0,0.25)] w-full max-w-3xl flex flex-col animate-fade-up border border-white" style="max-height: 92vh;">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white shrink-0 rounded-t-[3rem]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 text-[#0076df] rounded-2xl flex items-center justify-center shadow-inner border border-blue-100/50">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-xl font-black text-gray-800">إضافة فرصة جديدة</h3>
                            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-1">تعبئة بيانات التدريب الميداني</p>
                        </div>
                    </div>
                    <button onclick="closeModal('addModal')" class="w-10 h-10 bg-gray-50 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all flex items-center justify-center"><i class="fas fa-times"></i></button>
                </div>

                <div class="overflow-y-auto p-10 pt-6 custom-scrollbar">
                    <form id="addInternshipForm" action="{{route('company.storeInternships')}}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-3">
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">مسمى الفرصة التدريبية</label>
                                <input type="text" name="title" placeholder="مثال: مطور تطبيقات الهاتف" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">وصف المهام والمهارات</label>
                                <textarea name="description" rows="4" placeholder="اكتب تفاصيل الفرصة هنا..." required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">تاريخ البدء</label>
                                <input type="date" name="start_date" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">تاريخ الانتهاء</label>
                                <input type="date" name="end_date" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">المدة (أشهر)</label>
                                <input type="text" name="duration" placeholder="مثال: 3 أشهر" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700 text-center">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">رابط تقديم الطلب</label>
                                <input type="url" name="internship_link" placeholder="https://forms.gle/..." required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[11px] text-gray-400 font-black mb-2 mr-2 uppercase tracking-widest ">صورة غلاف الفرصة</label>
                                <div class="relative border-2 border-dashed border-gray-100 rounded-[2.5rem] p-10 flex flex-col items-center justify-center bg-gray-50/50 hover:bg-white hover:border-blue-100 transition-all group cursor-pointer shadow-inner">
                                    <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'addPreview')">
                                    <div class="w-14 h-14 bg-white shadow-md rounded-2xl flex items-center justify-center text-blue-500 mb-4 group-hover:scale-110 transition-all">
                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 ">اسحب الصورة أو انقر هنا للتحميل</p>
                                    <img id="addPreview" class="mt-6 max-h-40 rounded-2xl hidden border-4 border-white shadow-xl">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-8 border-t border-gray-50 flex items-center gap-4 bg-white shrink-0 rounded-b-[3rem]">
                    <button type="submit" form="addInternshipForm" class="flex-1 bg-[#0076df] text-white py-4 rounded-2xl font-black shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                        <i class="fas fa-rocket"></i> نشر الفرصة الآن
                    </button>
                    <button type="button" onclick="closeModal('addModal')" class="px-12 py-4 bg-white border border-gray-100 text-gray-400 rounded-2xl font-black hover:bg-gray-50 transition-all">إلغاء</button>
                </div>
            </div>
        </div>

        {{-- مودال التعديل بنفس ستايل الإضافة --}}
        <div id="editModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/40 backdrop-blur-md hidden p-4">
            <div class="bg-white rounded-[3rem] shadow-[0_30px_80px_rgba(0,0,0,0.25)] w-full max-w-3xl flex flex-col animate-fade-up border border-white" style="max-height: 92vh;">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-white shrink-0 rounded-t-[3rem]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center shadow-inner border border-orange-100/50">
                            <i class="far fa-edit text-xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800 tracking-tight">تعديل بيانات الفرصة</h3>
                    </div>
                    <button onclick="closeModal('editModal')" class="text-gray-300 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="overflow-y-auto p-10 pt-6 custom-scrollbar">
                    <form id="editInternshipForm" action="{{route('company.updateInternship',$internship->id)}}" method="POST" enctype="multipart/form-data" class="space-y-6 text-right">
                        @csrf @method('PUT')
                        <input type="hidden" id="editInternshipId" name="internship_id">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">المسمى الوظيفي</label>
                                    <input type="text" id="editTitle" name="title" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                                </div>
                                <div>
                                    <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">الحالة</label>
                                    <select id="editStatus" name="status" class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700 appearance-none text-center">
                                        <option value="مفتوحة">مفتوحة</option>
                                        <option value="مغلقة">مغلقة</option>
                                        <option value="مكتملة">مكتملة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">وصف الفرصة</label>
                                <textarea id="editDescription" name="description" rows="3" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">تاريخ البدء</label>
                                <input type="date" id="editStartDate" name="start_date" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">تاريخ الانتهاء</label>
                                <input type="date" id="editEndDate" name="end_date" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">المدة</label>
                                <input type="text" id="editDuration" name="duration" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>
                            <div>
                                <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">رابط تقديم الطلب</label>
                                <input type="text" id="editInternshipLink" name="internship_link" required class="custom-input w-full p-4 rounded-2xl text-sm font-black text-gray-700">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[11px] text-gray-400 font-black mb-2 uppercase  tracking-widest">الغلاف الحالي</label>
                                <div class="relative group h-48 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-lg">
                                    <img id="editPreviewImage" src="" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center backdrop-blur-sm">
                                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, 'editPreviewImage')">
                                        <span class="bg-white px-8 py-3 rounded-2xl text-xs font-black shadow-2xl tracking-tight">تغيير الصورة</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-8 border-t border-gray-50 flex items-center gap-4 bg-white shrink-0 rounded-b-[3rem]">
                    <button type="submit" form="editInternshipForm" class="flex-1 bg-[#0076df] text-white py-4 rounded-2xl font-black shadow-xl hover:bg-blue-700 hover:-translate-y-1 transition-all">تحديث البيانات الآن</button>
                    <button type="button" onclick="closeModal('editModal')" class="px-12 py-4 bg-white border border-gray-100 text-gray-400 rounded-2xl font-black hover:bg-gray-50 transition-all">إلغاء</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        function openEditModal(internship) {
            const form = document.getElementById('editInternshipForm');
            form.action = `/companyUpdateInternships/${internship.id}`;
            document.getElementById('editInternshipId').value = internship.id;
            document.getElementById('editTitle').value = internship.title;
            document.getElementById('editDescription').value = internship.description;
            document.getElementById('editStatus').value = internship.status;
            document.getElementById('editStartDate').value = internship.start_date;
            document.getElementById('editEndDate').value = internship.end_date;
            document.getElementById('editDuration').value = internship.duration;
            document.getElementById('editInternshipLink').value = internship.internship_link;
            document.getElementById('editPreviewImage').src = internship.image ? `/storage/internships/${internship.image}` : '/assets/img/placeholder.png';
            openModal('editModal');
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذه الفرصة بشكل نهائي!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'تراجع',
                reverseButtons: true
            }).then((result) => { if (result.isConfirmed) button.closest('form').submit(); });
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); }
                reader.readAsDataURL(input.files[0]);
            }
        }

        window.onclick = e => { if (e.target.classList.contains('backdrop-blur-md')) closeModal(e.target.id); }
    </script>
@endsection
