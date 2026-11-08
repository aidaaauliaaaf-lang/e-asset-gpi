
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Profil Karyawan</h2>
        <p class="text-muted mb-0">
            Kelola informasi profil Anda di E-Asset Golden Piping Indonesia.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- Kartu profil --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">

                    <div class="mb-3">
                        @if (!empty($user->foto))
                            <img
                                src="{{ asset('storage/' . $user->foto) }}"
                                alt="Foto Profil"
                                class="rounded-circle border"
                                style="width:150px;height:150px;object-fit:cover;"
                            >
                        @else
                            <div
                                class="rounded-circle bg-light border d-inline-flex align-items-center justify-content-center"
                                style="width:150px;height:150px;"
                            >
                                <i class="bi bi-person-circle text-secondary"
                                    style="font-size:100px;"></i>
                            </div>
                        @endif
                    </div>

                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>

                    <p class="text-muted mb-3">
                        {{ $user->jabatan ?: 'Jabatan belum diisi' }}
                    </p>

                    <span class="badge bg-primary px-3 py-2">
                        {{ strtoupper($user->role ?? 'Karyawan') }}
                    </span>

                    <hr class="my-4">

                    <div class="text-start">
                        <p class="text-muted small mb-1">Username</p>
                        <p class="fw-semibold text-break">
                            {{ $user->user ?: '-' }}
                        </p>

                        <p class="text-muted small mb-1">NIK</p>
                        <p class="fw-semibold">
                            {{ $user->nik ?: '-' }}
                        </p>

                        <p class="text-muted small mb-1">Divisi</p>
                        <p class="fw-semibold mb-0">
                            {{ $user->divisi ?: '-' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Form edit profil --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>
                        Informasi Pribadi
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form
                        action="{{ route('profile.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Nama --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Username --}}
                            <div class="col-md-6">
                                <label for="user" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="user"
                                    name="user"
                                    class="form-control @error('user') is-invalid @enderror"
                                    value="{{ old('user', $user->user) }}"
                                    required
                                >
                                @error('user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NIK --}}
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK</label>
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

                            {{-- Nomor telepon --}}
                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label">
                                    Nomor Telepon
                                </label>
                                <input
                                    type="text"
                                    id="no_telepon"
                                    name="no_telepon"
                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                    value="{{ old('no_telepon', $user->no_telepon) }}"
                                    maxlength="20"
                                    placeholder="Contoh: 08xxxxxxxxxx"
                                >
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jabatan --}}
                            <div class="col-md-6">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input
                                    type="text"
                                    id="jabatan"
                                    name="jabatan"
                                    class="form-control @error('jabatan') is-invalid @enderror"
                                    value="{{ old('jabatan', $user->jabatan) }}"
                                    maxlength="100"
                                    placeholder="Contoh: Staff IT"
                                >
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Divisi --}}
                            <div class="col-md-6">
                                <label for="divisi" class="form-label">Divisi</label>
                                <input
                                    type="text"
                                    id="divisi"
                                    name="divisi"
                                    class="form-control @error('divisi') is-invalid @enderror"
                                    value="{{ old('divisi', $user->divisi) }}"
                                    maxlength="100"
                                    placeholder="Contoh: Teknologi Informasi"
                                >
                                @error('divisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Foto profil --}}
                            <div class="col-12">
                                <label for="foto" class="form-label">
                                    Foto Profil
                                </label>
                                <input
                                    type="file"
                                    id="foto"
                                    name="foto"
                                    class="form-control @error('foto') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >
                                <div class="form-text">
                                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                                </div>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="col-12 mt-4">
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i>
                                        Simpan Perubahan
                                    </button>

                                    <a href="{{ route('dashboard') }}"
                                        class="btn btn-outline-secondary">
                                        Kembali ke Dashboard
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
