@extends('layouts.app')
@section('title', 'Add New Lead — CRM Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Add New Lead</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Create a new lead (project) for a customer</p>
        </div>
        <a href="{{ route('leads.index') }}" class="flex items-center gap-2.5 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-2xl text-sm font-bold shadow-sm hover:bg-slate-50 transition active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('leads.store') }}" class="divide-y divide-slate-50">
            @csrf

            <div class="p-8 md:p-10">
                <div class="space-y-8">
                    <!-- Customer Type Toggle -->
                    <div class="flex flex-col gap-4">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Customer Selection <span class="text-rose-500">*</span></label>
                        <div class="flex p-1 bg-slate-100 rounded-2xl w-fit">
                            <input type="hidden" name="customer_type" id="customer_type" value="{{ old('customer_type', 'new') }}">
                            <button type="button" onclick="toggleCustomerType('new')" id="btn_new" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ old('customer_type', 'new') === 'new' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                                New Customer
                            </button>
                            <button type="button" onclick="toggleCustomerType('existing')" id="btn_existing" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ old('customer_type') === 'existing' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                                Existing Customer
                            </button>
                        </div>
                    </div>

                    <!-- Existing Customer Selection -->
                    <div id="existing_customer_section" class="{{ old('customer_type') === 'existing' ? '' : 'hidden' }} space-y-8">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Select Existing Customer <span class="text-rose-500">*</span></label>
                            <select name="customer_id" id="customer_id" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                                <option value="">-- Choose a Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} {{ $customer->phone ? "({$customer->phone})" : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- New Customer Fields -->
                    <div id="new_customer_section" class="{{ old('customer_type', 'new') === 'new' ? '' : 'hidden' }} space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Client Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" placeholder="e.g. John Doe" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            </div>

                            <div class="flex flex-col gap-2.5">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Project Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="project_name" value="{{ old('project_name') }}" required placeholder="e.g. eCommerce Website Redesign" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +1 234 567 890" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            </div>

                            <div class="flex flex-col gap-2.5">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. john@example.com" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Common Project Info (Only shown if Existing selected, otherwise handled in New Section grid) -->
                    <div id="project_info_existing" class="{{ old('customer_type') === 'existing' ? '' : 'hidden' }} flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Project Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="project_name_existing" id="project_name_existing" value="{{ old('project_name') }}" placeholder="e.g. eCommerce Website Redesign" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Status <span class="text-rose-500">*</span></label>
                        <select name="status" required class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirm" {{ old('status') === 'Confirm' ? 'selected' : '' }}>Confirm</option>
                            <option value="Followup" {{ old('status') === 'Followup' ? 'selected' : '' }}>Followup</option>
                            <option value="Not Interested" {{ old('status') === 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
                        </select>
                    </div>
                </div>
            </div>

            <script>
                function toggleCustomerType(type) {
                    const input = document.getElementById('customer_type');
                    const btnNew = document.getElementById('btn_new');
                    const btnExisting = document.getElementById('btn_existing');
                    const sectionNew = document.getElementById('new_customer_section');
                    const sectionExisting = document.getElementById('existing_customer_section');
                    const projectExisting = document.getElementById('project_info_existing');
                    
                    input.value = type;
                    
                    if (type === 'new') {
                        btnNew.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
                        btnNew.classList.remove('text-slate-500');
                        btnExisting.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
                        btnExisting.classList.add('text-slate-500');
                        
                        sectionNew.classList.remove('hidden');
                        sectionExisting.classList.add('hidden');
                        projectExisting.classList.add('hidden');
                        
                        // Sync project names if one was typed
                        const existingProj = document.getElementById('project_info_existing').querySelector('input');
                        const newProj = sectionNew.querySelector('input[name="project_name"]');
                        if (existingProj.value) newProj.value = existingProj.value;
                        
                    } else {
                        btnExisting.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
                        btnExisting.classList.remove('text-slate-500');
                        btnNew.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
                        btnNew.classList.add('text-slate-500');
                        
                        sectionExisting.classList.remove('hidden');
                        sectionNew.classList.add('hidden');
                        projectExisting.classList.remove('hidden');

                        // Sync project names
                        const existingProj = document.getElementById('project_info_existing').querySelector('input');
                        const newProj = sectionNew.querySelector('input[name="project_name"]');
                        if (newProj.value) existingProj.value = newProj.value;
                    }
                }

                // Handle form submission to ensure project_name is always in the right field
                document.querySelector('form').addEventListener('submit', function(e) {
                    const type = document.getElementById('customer_type').value;
                    const newProj = document.querySelector('input[name="project_name"]');
                    const existingProj = document.getElementById('project_name_existing');
                    
                    if (type === 'existing') {
                        newProj.value = existingProj.value;
                    }
                });
            </script>

            <div class="p-8 md:p-10 bg-slate-50/50 flex items-center justify-end gap-4">
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 active:scale-95">
                    Save Lead
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
