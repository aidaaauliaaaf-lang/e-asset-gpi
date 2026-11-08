
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Edit Pengguna</h2>
        <p class="text-muted mb-0">
            Perbarui identitas dan hak akses pengguna E-Asset GPI.
        </p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

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
        <strong>Informasi Akun</strong>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    Alamat Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="role" class="form-label fw-semibold">
                    Role Pengguna
                </label>
                <select id="role" name="role" class="form-select" required>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>
                        Admin
                    </option>
                    <option value="karyawan" @selected(old('role', $user->role) === 'karyawan')>
                        Karyawan
                    </option>
                    <option value="pimpinan" @selected(old('role', $user->role) === 'pimpinan')>
                        Pimpinan
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    Password Baru
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    minlength="8"
                    autocomplete="new-password"
                >
                <small class="text-muted">
                    Kosongkan jika tidak ingin mengubah password.
                </small>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('users.index') }}"
                   class="btn btn-light border">
                    Batal
                </a>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
