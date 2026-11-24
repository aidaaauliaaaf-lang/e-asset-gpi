
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Edit Pengguna</h2>
        <p class="text-muted mb-0">
            Perbarui identitas, informasi pekerjaan, dan hak akses pengguna E-Asset GPI.
        </p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali data berikut:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0">

    <div class="card-header bg-dark text-white py-3">
        <strong>
            <i class="bi bi-person-vcard me-2"></i>
            Informasi Akun dan Karyawan
        </strong>
    </div>

    <div class="card-body p-4">

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- IDENTITAS PENGGUNA --}}
            <h6 class="text-danger fw-bold mb-3">
                <i class="bi bi-person-lines-fill me-2"></i>
                IDENTITAS PENGGUNA
            </h6>

            <div class="row">

                {{-- Nama Lengkap --}}
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-semibold">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}"
                        maxlength="255"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label fw-semibold">
                        Username
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', $user->user ?? $user->username) }}"
                        maxlength="255"
                        autocomplete="username"
                        required
                    >
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NIK --}}
                <div class="col-md-6 mb-3">
                    <label for="nik" class="form-label fw-semibold">
                        NIK
                    </label>
                    <input
                        type="text"
                        id="nik"
                        name="nik"
                        class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik', $user->nik) }}"
                        maxlength="30"
                    >
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="col-md-6 mb-3">
                    <label for="no_telepon" class="form-label fw-semibold">
                        Nomor Telepon
                    </label>
                    <input
                        type="text"
                        id="no_telepon"
                        name="no_telepon"
                        class="form-control @error('no_telepon') is-invalid @enderror"
                        value="{{ old('no_telepon', $user->no_telepon) }}"
                        maxlength="20"
                    >
                    @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jabatan --}}
                <div class="col-md-6 mb-3">
                    <label for="jabatan" class="form-label fw-semibold">
                        Jabatan
                    </label>
                    <input
                        type="text"
                        id="jabatan"
                        name="jabatan"
                        class="form-control @error('jabatan') is-invalid @enderror"
                        value="{{ old('jabatan', $user->jabatan) }}"
                        maxlength="100"
                    >
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Divisi --}}
                <div class="col-md-6 mb-3">
                    <label for="divisi" class="form-label fw-semibold">
                        Divisi
                    </label>
                    <input
                        type="text"
                        id="divisi"
                        name="divisi"
                        class="form-control @error('divisi') is-invalid @enderror"
                        value="{{ old('divisi', $user->divisi) }}"
                        maxlength="100"
                    >
                    @error('divisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <hr class="my-4">

            {{-- HAK AKSES --}}
            <h6 class="text-danger fw-bold mb-3">
                <i class="bi bi-shield-lock me-2"></i>
                HAK AKSES PENGGUNA
            </h6>

            <div class="mb-3">
                <label for="role" class="form-label fw-semibold">
                    Role Pengguna
                </label>

                <select
                    id="role"
                    name="role"
                    class="form-select @error('role') is-invalid @enderror"
                    required
                >
                    <option value="admin"
                        @selected(old('role', $user->role) === 'admin')>
                        Admin
                    </option>

                    <option value="karyawan"
                        @selected(old('role', $user->role) === 'karyawan')>
                        Karyawan
                    </option>

                    <option value="pimpinan"
                        @selected(old('role', $user->role) === 'pimpinan')>
                        Pimpinan
                    </option>
                </select>

                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="text-muted">
                    Role menentukan hak akses pengguna dalam sistem E-Asset GPI.
                </small>
            </div>

            <hr class="my-4">

            {{-- KEAMANAN AKUN --}}
            <h6 class="text-danger fw-bold mb-3">
                <i class="bi bi-key-fill me-2"></i>
                KEAMANAN AKUN
            </h6>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    Password Baru
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    minlength="8"
                    autocomplete="new-password"
                >

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengubah password.
                </small>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    minlength="8"
                    autocomplete="new-password"
                >
            </div>

            <hr class="my-4">

            {{-- TOMBOL --}}
            <div class="d-flex justify-content-end gap-2 mt-4">

                <a href="{{ route('users.index') }}"
                   class="btn btn-light border">
                    <i class="bi bi-x-circle me-1"></i>
                    Batal
                </a>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-save me-2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>
</div>

@endsection
