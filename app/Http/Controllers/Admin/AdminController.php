<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //

    public function logon()
    {
        return view('admin.logon');
    }
    public function InLogon(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->role == 1) {
                return redirect()->route('admin.index');
                // dd($request->all());
            } else {
                return redirect()->back()->with('error', 'Tài khoản của bạn không có quyền truy cập vào trang admin.');
            }
        }

        return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác.');
    }

    public function SigOut()
    {
        Auth::logout();
        return redirect()->route('logon');
    }
}
