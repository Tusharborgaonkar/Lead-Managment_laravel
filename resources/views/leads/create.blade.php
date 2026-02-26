@extends('layouts.app')
@section('title', 'Add New Lead — CRM Admin')

@section('content')
<div class="min-h-screen -m-6 p-12 bg-[#f8fafc]/50 dark:bg-slate-950/50">
    <div class="max-w-7xl mx-auto">
        {{-- Page Header --}}
        <div class="mb-10">
            <div class="flex items-center gap-3">
                <a href="{{ route('leads.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-6 h-6"></i>
                </a>
                <h1 class="text-[28px] font-black text-[#1e293b] dark:text-white">Add New Lead</h1>
            </div>
            <p class="text-sm text-slate-400 font-medium ml-9">Fill in the details to create a new lead in your pipeline.</p>
        </div>

        {{-- Main Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-50 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none overflow-hidden">
            <div class="p-16">
                @if ($errors->any())
                    <div class="mb-8 p-6 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 text-sm font-bold">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            <span>Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 ml-7">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('leads.store') }}" class="space-y-12">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-12">
                        {{-- Full Name --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Full Name <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="user" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="John Doe" />
                            </div>
                        </div>

                        {{-- Mobile / Phone --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Mobile / Phone <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="phone" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="+1-305-555-0142" />
                            </div>
                        </div>

                        {{-- Secondary Mobile (Optional) --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Alternative Mobile <span class="text-slate-400 font-medium">(Optional)</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="smartphone" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="text" name="optional_phone" value="{{ old('optional_phone') }}"
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="+1-305-555-0999" />
                            </div>
                        </div>

                        {{-- Email Address --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Email Address</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="mail" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="name@company.com" />
                            </div>
                        </div>

                        {{-- Company Name --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Company Name</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="building-2" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="text" name="company" value="{{ old('company') }}"
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="Acme Corporation" />
                            </div>
                        </div>

                        {{-- Website --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Website</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="globe" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="url" name="website" value="{{ old('website') }}"
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="https://example.com" />
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="space-y-3">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Location</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="text" name="location" value="{{ old('location') }}"
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm"
                                       placeholder="City, State, or Address" />
                            </div>
                        </div>

                        {{-- Status & Source Row --}}
                        <div class="grid grid-cols-2 gap-8 lg:col-span-2">
                            <div class="space-y-3">
                                <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Lead Status <span class="text-rose-500">*</span></label>
                                <div class="relative group group-select">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none z-10">
                                        <i data-lucide="star" class="w-5 h-5 text-indigo-500"></i>
                                    </div>
                                    <select name="status" required
                                            class="w-full pl-14 pr-10 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer shadow-sm">
                                        @foreach(config('data.lead_statuses', []) as $status)
                                            <option value="{{ $status }}" {{ old('status', 'new') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-300"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Source</label>
                                <div class="relative group">
                                    <select name="source"
                                            class="w-full px-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer shadow-sm">
                                        <option value="">Select source</option>
                                        @foreach(config('data.lead_sources', []) as $src)
                                            <option value="{{ $src }}" {{ old('source') === $src ? 'selected' : '' }}>{{ $src }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-5 h-5 text-slate-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Required Followup Types (Checkboxes) --}}
                        <div class="col-span-full bg-slate-50 dark:bg-slate-800/50 rounded-3xl p-8 border border-slate-100 dark:border-slate-800/60 transition-all">
                            <label class="block text-[14px] font-black text-slate-800 dark:text-white mb-6">Preferred Follow-up Method(s)</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                {{-- WhatsApp --}}
                                <label class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-emerald-500/50 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 cursor-pointer transition-all group">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" name="followup_methods[]" value="whatsapp" class="peer sr-only">
                                        <div class="w-6 h-6 rounded-md border-2 border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all flex items-center justify-center">
                                            <i data-lucide="check" class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="message-circle" class="w-5 h-5 text-emerald-500"></i>
                                        <span class="text-[14px] font-bold text-slate-700 dark:text-slate-300 group-hover:text-emerald-600 transition-colors">WhatsApp</span>
                                    </div>
                                </label>

                                {{-- Email --}}
                                <label class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-indigo-500/50 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 cursor-pointer transition-all group">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" name="followup_methods[]" value="email" class="peer sr-only">
                                        <div class="w-6 h-6 rounded-md border-2 border-slate-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-500 transition-all flex items-center justify-center">
                                            <i data-lucide="check" class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="mail-plus" class="w-5 h-5 text-indigo-500"></i>
                                        <span class="text-[14px] font-bold text-slate-700 dark:text-slate-300 group-hover:text-indigo-600 transition-colors">Email</span>
                                    </div>
                                </label>

                                {{-- Cold Call --}}
                                <label class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-rose-500/50 hover:bg-rose-50/50 dark:hover:bg-rose-900/10 cursor-pointer transition-all group">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" name="followup_methods[]" value="cold_call" class="peer sr-only">
                                        <div class="w-6 h-6 rounded-md border-2 border-slate-300 peer-checked:border-rose-500 peer-checked:bg-rose-500 transition-all flex items-center justify-center">
                                            <i data-lucide="check" class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 scale-50 peer-checked:scale-100 transition-all"></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="phone-call" class="w-5 h-5 text-rose-500"></i>
                                        <span class="text-[14px] font-bold text-slate-700 dark:text-slate-300 group-hover:text-rose-600 transition-colors">Cold Call</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Followup Date & Time (Conditional) --}}
                        <div id="followup-container" class="space-y-3 hidden col-span-full">
                            <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Followup Date & Time <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <i data-lucide="calendar" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                </div>
                                <input type="datetime-local" name="followup_date" id="followup_date" 
                                       value="{{ old('followup_date') }}"
                                       class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" />
                            </div>
                        </div>
                    </div>

                    {{-- Notes Section --}}
                    <div class="space-y-3">
                        <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200">Initial Conversation Notes</label>
                        <textarea name="notes" rows="4"
                                  class="w-full px-8 py-7 rounded-[2.5rem] bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-medium text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm resize-none"
                                  placeholder="What was discussed? (e.g., Budget, requirement, follow-up date)">{{ old('notes') }}</textarea>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit"
                                class="px-10 py-4 bg-[#4f46e5] text-white rounded-2xl font-black text-[15px] flex items-center gap-3 shadow-xl shadow-indigo-500/30 hover:bg-indigo-700 hover:translate-y-[-1px] transition-all duration-200">
                            <i data-lucide="save" class="w-5 h-5"></i> Save Lead
                        </button>
                        <a href="{{ route('leads.index') }}" class="px-8 py-4 text-[15px] font-black text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const followupContainer = document.getElementById('followup-container');
        const followupInput = document.getElementById('followup_date');
        
        function toggleFollowup(animate = true) {
            const isFollowup = statusSelect.value.toLowerCase() === 'followup';
            
            if (isFollowup) {
                followupContainer.classList.remove('hidden');
                if (animate) {
                    followupContainer.style.opacity = '0';
                    followupContainer.style.transform = 'translateY(-10px)';
                    followupContainer.classList.add('transition-all', 'duration-300');
                    setTimeout(() => {
                        followupContainer.style.opacity = '1';
                        followupContainer.style.transform = 'translateY(0)';
                    }, 10);
                }
                followupInput.setAttribute('required', 'required');
            } else {
                followupContainer.classList.add('hidden');
                followupInput.removeAttribute('required');
            }
        }
        
        statusSelect.addEventListener('change', () => toggleFollowup(true));
        toggleFollowup(false); // Initial check without animation
    });
</script>
@endpush
@endsection
