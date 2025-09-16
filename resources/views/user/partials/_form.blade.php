<div class="row">
    <div class="col-md-6">
        <x-form-input
            name="name"
            label="Nama"
            placeholder="Masukkan nama user"
            value="{{ old('name', $user->name ?? '') }}"
            required />
    </div>
    <div class="col-md-6">
        <x-form-input
            name="email"
            label="Email"
            type="email"
            placeholder="Masukkan email user"
            value="{{ old('email', $user->email ?? '') }}"
            required />
    </div>
</div>

@if(isset($update) && $update)
<div class="row">
    <div class="col-md-6">
        <x-form-input
            name="password"
            label="Password (Kosongkan jika tidak ingin mengubah)"
            type="password"
            placeholder="Masukkan password baru"
            value="" />
    </div>
    <div class="col-md-6">
        <x-form-input
            name="password_confirmation"
            label="Konfirmasi Password"
            type="password"
            placeholder="Konfirmasi password baru"
            value="" />
    </div>
</div>
@else
<div class="row">
    <div class="col-md-6">
        <x-form-input
            name="password"
            label="Password"
            type="password"
            placeholder="Masukkan password"
            value=""
            required />
    </div>
    <div class="col-md-6">
        <x-form-input
            name="password_confirmation"
            label="Konfirmasi Password"
            type="password"
            placeholder="Konfirmasi password"
            value=""
            required />
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
            <option value="">Pilih Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" 
                    {{ old('role', isset($user) && $user->hasRole($role->name) ? $role->name : '') == $role->name ? 'selected' : '' }}>
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
        @error('role')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

@if (isset($user) && $user->hasRole('admin'))
<div class="alert alert-warning mt-3">
    <i class="fas fa-exclamation-triangle"></i>
    <strong>Peringatan:</strong> Anda sedang mengedit user dengan role admin. Harap berhati-hati dalam melakukan perubahan.
</div>
@endif

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) && $update ? 'Update' : 'Simpan' }}
    </x-primary-button>
    <x-tombol-kembali href="{{ route('user.index') }}" />
</div>