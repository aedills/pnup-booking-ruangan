<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                        'number' => $admin->number
                    ]);


                    return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login');
                } else {
                    return back()->with('error', 'Password yang Anda masukkan salah. Silahkan coba lagi.');
                }
            } else {
                return back()->with('error', 'User tidak ditemukan. Silahkan hubungi admin.');
            }
        } catch (ValidationException) {
            return back()->with('error', 'Terdapat kesalahan pada input form');
        } catch (\Exception $err) {
            return back()->with('error', 'Terdapat kesalahan ketika melakukan login');
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
                    return back()->with('error', 'Password baru tidak boleh sama dengan password lama.');
                }

                $admin->password = Hash::make($request->newPassword);
                $status = $admin->save();

                if ($status) {
                    return back()->with('success', 'Berhasil memperbarui password');
                } else {
                    return back()->with('error', 'Terdapat kesalahan ketika memperbarui password');
                }
            } else {
                return back()->with('error', 'Password yang Anda masukkan salah! Silahkan coba lagi.');
            }
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada input form');
        } catch (\Exception $err) {
            return back()->with('error', 'Terdapat kesalahan ketika melakukan update password');
        }
    }

    public function changeNumber(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|max:255',
                'newNumber' => 'required|string|max:14',
            ]);

            $number = $request->newNumber;

            if (str_starts_with($number, '08')) {
                $phoneNumber = preg_replace('/^0/', '62', $number);
            }

            $admin = Auth::find(session('id'));

            if (Hash::check($request->password, $admin->password)) {
                if ($phoneNumber == session('number')) {
                    return back()->with('error', 'Nomor yang Anda masukkan sama dengan nomor lama.');
                }


                $admin->number = $phoneNumber;
                $status = $admin->save();

                $newAdmin = Auth::find(session('id'));
                if ($newAdmin) {
                    $request->session()->flush();
                    $request->session()->regenerate();
                    $request->session()->put([
                        'id' => $newAdmin->id,
                        'uuid' => $newAdmin->uuid,
                        'username' => $newAdmin->username,
                        'number' => $newAdmin->number
                    ]);
                } else {
                    return back()->with('error', 'Terjadi kesalahan, harap coba lagi.');
                }

                if ($status) {
                    return back()->with('success', 'Berhasil memperbarui nomor');
                } else {
                    return back()->with('error', 'Terdapat kesalahan ketika memperbarui nomor');
                }
            } else {
                return back()->with('error', 'Password yang Anda masukkan salah! Silahkan coba lagi.');
            }
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada input form');
        } catch (\Exception $err) {
            return back()->with('error', 'Terdapat kesalahan ketika melakukan update nomor');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('auth.login')->with('success', 'Anda berhasil keluar!');
    }
}
