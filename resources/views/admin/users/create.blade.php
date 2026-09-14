@extends('layouts.admin')

@section('title', 'Add Admin User')
@section('page_title', 'Add Admin User')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Users</span>
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Full Name <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   placeholder="e.g. John Doe" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label for="email" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Email Address <span class="text-red-500">*</span>
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   placeholder="john@nusantara-lng.com" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label for="password" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   minlength="8" 
                   placeholder="Minimum 8 characters" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label for="role" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Role &amp; Permissions <span class="text-red-500">*</span>
            </label>
            <select id="role" name="role" required class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin (Full Access)</option>
                <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor (Content &amp; Portfolio Only)</option>
            </select>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Create User &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
