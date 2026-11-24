<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login.
     */
    public function show(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        if (!$user) {
            abort(404, 'Data pengguna tidak ditemukan.');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Memperbarui profil atau password pengguna.
     */
    public function update(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        if (!$user) {
            abort(404, 'Data pengguna tidak ditemukan.');
        }

        $isAdmin = strtolower(
            (string) $request->session()->get('user_role')
        ) === 'admin';

        /*
         * BAGIAN 1: UBAH PASSWORD
         * Tidak memerlukan password lama.
         */
        if ($request->input('change_password') == '1') {

            $validated = $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ], [
                'password.required' =>
                    'Password baru wajib diisi.',

                'password.min' =>
                    'Password baru minimal 8 karakter.',

                'password.confirmed' =>
                    'Konfirmasi password baru tidak cocok.',
            ]);

            // Simpan password baru.
            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'password' => Hash::make($validated['password']),
                    'updated_at' => now(),
                ]);

            return redirect()
                ->route('profile.show')
                ->with('success', 'Password berhasil diperbarui.');
        }

        /*
         * BAGIAN 2: VALIDASI PROFIL
         */
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'user' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'user')->ignore($userId),
            ],

            'no_telepon' => [
                'nullable',
                'string',
                'max:20',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];

        // Hanya Admin yang boleh mengubah NIK, jabatan, dan divisi.
        if ($isAdmin) {
            $rules['nik'] = [
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'nik')->ignore($userId),
            ];

            $rules['jabatan'] = [
                'nullable',
                'string',
                'max:100',
            ];

            $rules['divisi'] = [
                'nullable',
                'string',
                'max:100',
            ];
        }

        $validated = $request->validate($rules);

        /*
         * BAGIAN 3: DATA YANG BOLEH DIPERBARUI
         */
        $data = [
            'name' => $validated['name'],
            'user' => $validated['user'],
            'username' => $validated['user'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'updated_at' => now(),
        ];

        // Data khusus Admin.
        // Input dari Karyawan tidak digunakan.
        if ($isAdmin) {
            $data['nik'] = $validated['nik'] ?? null;
            $data['jabatan'] = $validated['jabatan'] ?? null;
            $data['divisi'] = $validated['divisi'] ?? null;
        }

        /*
         * BAGIAN 4: UPLOAD FOTO PROFIL
         */
        $fotoLama = $user->foto;
        $fotoBaru = null;

        if ($request->hasFile('foto')) {
            $fotoBaru = $request->file('foto')
                ->store('foto-karyawan', 'public');

            $data['foto'] = $fotoBaru;
        }

        /*
         * BAGIAN 5: SIMPAN KE DATABASE
         */
        try {
            DB::table('users')
                ->where('id', $userId)
                ->update($data);
        } catch (\Throwable $e) {

            // Hapus foto baru jika penyimpanan database gagal.
            if ($fotoBaru) {
                Storage::disk('public')->delete($fotoBaru);
            }

            throw $e;
        }

        // Hapus foto lama setelah database berhasil diperbarui.
        if ($fotoBaru && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        // Perbarui session nama pengguna.
        $request->session()->put('user_name', $validated['name']);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
