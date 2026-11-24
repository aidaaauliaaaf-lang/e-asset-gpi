<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    private const ROLES = [
        'admin',
        'karyawan',
        'pimpinan',
    ];

    /**
     * Memastikan hanya Admin yang dapat mengelola pengguna.
     */
    private function authorizeAdmin(Request $request): void
    {
        abort_unless(
            $request->session()->get('user_role') === 'admin',
            403,
            'Anda tidak memiliki akses untuk mengelola pengguna.'
        );
    }

    /**
     * Menampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah pengguna.
     */
    public function create(Request $request)
    {
        $this->authorizeAdmin($request);

        return view('users.create');
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,user',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in(self::ROLES),
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'user' => $validated['username'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(Request $request, User $user)
    {
        $this->authorizeAdmin($request);

        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'user')->ignore($user->id),
            ],

            'nik' => [
                'nullable',
                'string',
                'max:30',
            ],

            'no_telepon' => [
                'nullable',
                'string',
                'max:20',
            ],

            'jabatan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'divisi' => [
                'nullable',
                'string',
                'max:100',
            ],

            'role' => [
                'required',
                Rule::in(self::ROLES),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        // Admin tidak boleh menurunkan role akunnya sendiri.
        if (
            $user->id === (int) $request->session()->get('user_id')
            && $validated['role'] !== 'admin'
        ) {
            return back()
                ->withErrors([
                    'role' => 'Anda tidak dapat mengubah role akun sendiri.',
                ])
                ->withInput();
        }

        // Memperbarui identitas pengguna.
        $user->name = $validated['name'];

        // Kolom user merupakan kolom utama untuk login.
        $user->user = $validated['username'];

        // Kolom username tetap disinkronkan.
        $user->username = $validated['username'];

        // Informasi karyawan yang hanya dapat diubah Admin.
        $user->nik = $validated['nik'] ?? null;
        $user->no_telepon = $validated['no_telepon'] ?? null;
        $user->jabatan = $validated['jabatan'] ?? null;
        $user->divisi = $validated['divisi'] ?? null;

        // Memperbarui hak akses.
        $user->role = $validated['role'];

        // Password hanya berubah jika Admin mengisinya.
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
