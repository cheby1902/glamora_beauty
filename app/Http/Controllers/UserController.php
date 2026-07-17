<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    User::create([
    'nama_user' => $request->nama_user,
    'username' => $request->username,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'user'
]);
    return response()->json([
        'success' => true,
        'message' => 'Register berhasil'
    ]);
}

    public function login(Request $request)
{
    $user = User::where('username', $request->username)
                ->where('email', $request->email)
                ->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak ditemukan'
        ]);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Password salah'
        ]);
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

    return redirect('/login');
}

public function destroy($id)
{
    User::destroy($id);

    return redirect('/admin-dashboard#user');
}

}