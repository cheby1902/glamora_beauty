<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   public function index()
    {
        // Ambil semua data user
        $users = User::all(); 
        
        // Kirim ke view user.index
        return view('user.index', compact('users'));
    }

    public function register(Request $request)
{

$validator = Validator::make(
    $request->all(),
    [
        'nama_user' => 'required|max:100',

        'username' => 'required|min:4|max:30|alpha_dash|unique:user,username',

        'email' => 'required|email|unique:user,email',

        'password' => 'required|min:8|max:50'
    ],

    [
        'nama_user.required' => 'Nama lengkap wajib diisi.',
        'nama_user.max' => 'Nama lengkap maksimal 100 karakter.',

        'username.required' => 'Username wajib diisi.',
        'username.min' => 'Username minimal 4 karakter.',
        'username.max' => 'Username maksimal 30 karakter.',
        'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda minus (-), atau underscore (_), tanpa spasi.',
        'username.unique' => 'Username sudah digunakan.',

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',

        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.max' => 'Password maksimal 50 karakter.'
    ]
);

if ($validator->fails()) {

    return response()->json([
        'errors' => $validator->errors()
    ], 422);

}

    $user = User::create([
        'nama_user' => $request->nama_user,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user'
    ]);

    // otomatis login
    $request->session()->put('user_id', $user->id_user);
    $request->session()->put('username', $user->username);
    $request->session()->put('role', $user->role);

    return response()->json([
        'success' => true,
        'message' => 'Registrasi berhasil'
    ]);
}

   public function login(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'username' => 'required|alpha_dash',
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda minus (-), atau underscore (_), tanpa spasi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'password.required' => 'Password wajib diisi.'
        ]
    );

    if ($validator->fails()) {

        return response()->json([
            'errors' => $validator->errors()
        ], 422);

    }

    // cek username
    $user = User::where('username', $request->username)->first();

    if (!$user) {

        return response()->json([
            'message' => 'Username tidak ditemukan.'
        ], 401);

    }

    // cek email
    if ($user->email != $request->email) {

        return response()->json([
            'message' => 'Email Salah.'
        ], 401);

    }

    // cek password
    if (!Hash::check($request->password, $user->password)) {

        return response()->json([
            'message' => 'Password salah.'
        ], 401);

    }

    $request->session()->put('user_id', $user->id_user);
    $request->session()->put('username', $user->username);
    $request->session()->put('role', $user->role);

    return response()->json([
        'success' => true,
        'role' => $user->role,
        'user' => $user
    ]);
}

public function logout(Request $request)
{
    $request->session()->flush();

    return redirect('/');
}

public function cekUsername(Request $request)
{
    $ada = User::where('username', $request->username)->exists();

    return response()->json([
        'exists' => $ada
    ]);
}

public function cekEmail(Request $request)
{
    $ada = User::where('email', $request->email)->exists();

    return response()->json([
        'exists' => $ada
    ]);
}

public function destroy($id)
{
    User::destroy($id);

    return redirect('/admin-dashboard#user');
}

}