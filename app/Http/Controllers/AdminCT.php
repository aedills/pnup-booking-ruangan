<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminCT extends Controller
{
    public function index(Request $request)
    {
        return view('admin/dashboard', [
            'title' => 'Dashboard | SIRARA'
        ]);
    }

    public function login(Request $request)
    {
        if ($request->session()->has('uuid')) {
            return redirect()->route('admin.dashboard')->with('success', 'Anda telah login!');
        }
        return view('admin/auth/login', [
            'title' => 'Sirara | Login'
        ]);
    }

    public function doLogin(Request $request)
    {
        // dd($request);
        try {
            $request->validate([
                'username' => 'required|string|max:100',
                'password' => 'required|string|max:255',
            ]);

            $admin = Auth::where('username', $request->input('username'))->first();

            if ($admin) {
                if (Hash::check($request->input('password'), $admin->password)) {

                    $request->session()->put([
                        'id' => $admin->id,
                        'uuid' => $admin->uuid,
                        'username' => $admin->username,
                    ]);


                    return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login');
                } else {
                    return back()->with('error', 'Password yang Anda masukkan salah. Silahkan coba lagi.')->withInput();
                }
            } else {
                return back()->with('error', 'User tidak ditemukan. Silahkan hubungi admin.')->withInput();
            }
        } catch (ValidationException) {
            return back()->with('error', 'Terdapat kesalahan pada input form')->withInput();
        } catch (\Exception $err) {
            return back()->with('error', 'Terdapat kesalahan ketika melakukan login')->withInput();
        }
    }

    public function changePass(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|max:255',
                'newPassword' => 'required|string|min:8',
            ]);

            $admin = Auth::find(session('id'));

            if (Hash::check($request->password, $admin->password)) {
                if ($request->password === $request->newPassword) {
                    return back()->with('error', 'Password baru tidak boleh sama dengan password lama.')->withInput();
                }

                $admin->password = Hash::make($request->newPassword);
                $status = $admin->save();

                if ($status) {
                    return back()->with('success', 'Berhasil memperbarui password');
                } else {
                    return back()->with('error', 'Terdapat kesalahan ketika memperbarui password')->withInput();
                }
            } else {
                return back()->with('error', 'Password yang Anda masukkan salah! Silahkan coba lagi.')->withInput();
            }
        } catch (ValidationException $e) {
            dd($e);
            return back()->with('error', 'Terdapat kesalahan pada input form')->withInput();
        } catch (\Exception $err) {
            dd($err);
            return back()->with('error', 'Terdapat kesalahan ketika melakukan update password')->withInput();
        }
    }


    public function logout(Request $request)
    {
        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil keluar!');
    }
}
