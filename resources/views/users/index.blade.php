
@extends('layouts.app')

@section('content')

{{-- =====================================================
     HEADER HALAMAN MANAJEMEN PENGGUNA
===================================================== --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Manajemen Pengguna
        </h2>

        <p class="text-muted mb-0">
            Kelola akun dan hak akses pengguna sistem E-Asset Golden Piping Indonesia.
        </p>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-danger">
        <i class="bi bi-person-plus-fill me-1"></i>
        Tambah Pengguna
    </a>

</div>


{{-- =====================================================
     NOTIFIKASI SUKSES
===================================================== --}}
@if (session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>

    </div>

@endif


{{-- =====================================================
     NOTIFIKASI ERROR
===================================================== --}}
@if ($errors->any())

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <strong>
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Periksa kembali data berikut:
        </strong>

        <ul class="mb-0 mt-2">

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>

    </div>

@endif


{{-- =====================================================
     KARTU DAFTAR PENGGUNA
===================================================== --}}
<div class="card shadow-sm border-0">

    {{-- HEADER CARD --}}
    <div class="card-header bg-dark text-white py-3">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-people-fill me-2"></i>
                    Daftar Pengguna
                </h5>

                <small class="text-light">
                    Informasi akun yang terdaftar dalam sistem.
                </small>

            </div>

            <span class="badge bg-danger px-3 py-2">
                {{ $users->total() }} Pengguna
            </span>

        </div>

    </div>


    {{-- ISI TABEL --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                {{-- HEADER TABEL --}}
                <thead class="table-light">

                    <tr>

                        <th class="text-center" width="60">
                            No.
                        </th>

                        <th>
                            Nama Pengguna
                        </th>

                        <th>
                            Username
                        </th>

                        <th class="text-center">
                            Role
                        </th>

                        <th>
                            Tanggal Dibuat
                        </th>

                        <th class="text-center" width="120">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- DATA PENGGUNA --}}
                <tbody>

                    @forelse ($users as $user)

                        <tr>

                            {{-- NOMOR --}}
                            <td class="text-center">
                                {{ $users->firstItem() + $loop->index }}
                            </td>


                            {{-- NAMA PENGGUNA --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $user->name }}
                                </div>

                            </td>


                            {{-- USERNAME --}}
                            <td>
                                {{ $user->username ?? $user->user ?? '-' }}
                            </td>


                            {{-- ROLE --}}
                            <td class="text-center">

                                @php
                                    $role = strtolower($user->role ?? '');

                                    $roleClass = match ($role) {
                                        'admin' => 'bg-danger',
                                        'pimpinan' => 'bg-primary',
                                        'karyawan' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp

                                <span class="badge {{ $roleClass }} px-3 py-2">
                                    {{ ucfirst($user->role ?? 'Tidak diketahui') }}
                                </span>

                            </td>


                            {{-- TANGGAL DIBUAT --}}
                            <td>
                                {{ $user->created_at?->format('d-m-Y') ?? '-' }}
                            </td>


                            {{-- AKSI --}}
                            <td class="text-center">

                                <a
                                    href="{{ route('users.edit', $user) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Edit Pengguna">

                                    <i class="bi bi-pencil-square me-1"></i>
                                    Edit

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center text-muted py-5">

                                <i class="bi bi-people fs-1 d-block mb-2"></i>

                                Belum ada pengguna yang terdaftar.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =================================================
         FOOTER DAN PAGINATION
    ================================================= --}}
    @if ($users->hasPages())

        <div class="card-footer bg-white py-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <small class="text-muted">

                    Menampilkan
                    {{ $users->firstItem() }}
                    sampai
                    {{ $users->lastItem() }}
                    dari
                    {{ $users->total() }}
                    pengguna

                </small>

                <div>
                    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

    @endif

</div>

@endsection
