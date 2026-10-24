<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Memperbarui profil pengguna.
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

        // Validasi data profil
        $validated = $request->validate([
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

            'nik' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'nik')->ignore($userId),
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
        ]);

        // Data yang akan diperbarui
        $data = [
            'name' => $validated['name'],
            'user' => $validated['user'],
            'nik' => $validated['nik'] ?? null,
            'jabatan' => $validated['jabatan'] ?? null,
            'divisi' => $validated['divisi'] ?? null,
            'no_telepon' => $validated['no_telepon'] ?? null,
            'updated_at' => now(),
        ];

        // Upload foto profil baru jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')
                ->store('foto-karyawan', 'public');

            // Hapus foto lama setelah foto baru berhasil disimpan
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            $data['foto'] = $path;
        }

        // Simpan perubahan ke database
        DB::table('users')
            ->where('id', $userId)
            ->update($data);

        // Perbarui nama pada session jika diperlukan
        $request->session()->put('user_name', $validated['name']);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
