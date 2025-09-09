{{-- resources/views/admin/users/_form-fields.blade.php --}}
{{-- Expects optional $user variable for editing --}}

{{-- First Name --}}
<div>
    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
    <input type="text" name="first_name" id="first_name" class="form-input w-full" value="{{ old('first_name', $user->first_name ?? '') }}" required>
    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Last Name --}}
<div>
    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
    <input type="text" name="last_name" id="last_name" class="form-input w-full" value="{{ old('last_name', $user->last_name ?? '') }}" required>
    @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Username --}}
<div>
    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
    <input type="text" name="username" id="username" class="form-input w-full" value="{{ old('username', $user->username ?? '') }}" required>
     <p class="text-xs text-gray-500 mt-1">Must be unique.</p>
    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Email --}}
<div>
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
    <input type="email" name="email" id="email" class="form-input w-full" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Password --}}
<div>
     {{-- Make label slightly different for edit vs create --}}
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password @isset($user)<span class="text-gray-500 text-xs">(Leave blank to keep current)</span>@else<span class="text-red-500">*</span>@endisset</label>
    <input type="password" name="password" id="password" class="form-input w-full" {{ isset($user) ? '' : 'required' }} autocomplete="new-password">
    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Password Confirmation --}}
<div>
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password @isset($user)<span class="text-gray-500 text-xs">(Required if changing password)</span>@else<span class="text-red-500">*</span>@endisset</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input w-full" {{ isset($user) ? '' : 'required' }} autocomplete="new-password">
    @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Role --}}
<div>
    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
    <select name="role" id="role" class="form-select w-full" required>
        <option value="{{ \App\Models\User::ROLE_USER }}" {{ old('role', $user->role ?? \App\Models\User::ROLE_USER) == \App\Models\User::ROLE_USER ? 'selected' : '' }}>User</option>
        <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ old('role', $user->role ?? '') == \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
    </select>
     @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Address Fields (Optional) --}}
{{-- Add address, city, state, zip, phone inputs here if needed, similar to above --}}