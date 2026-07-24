<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest; // Lab 09
// use Illuminate\Support\Facades\DB; // Lab 06 - Query Builder
use App\Models\User; // Lab 07 - Eloquent ORM

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // $list = DB::table('users')
        //     ->select('id', 'fullname', 'username', 'email', 'phone', 'address', 'role', 'status')
        //     ->where('status', 1)
        //     ->orderBy('fullname')
        //     ->get();
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        $limit = $request->input('limit', 10);
        $list = User::where('status', 1)->orderBy('fullname')->paginate($limit);
        // =================================================================

        return view('admin.users.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        // ===================== LAB 06 - Query Builder =====================
        // DB::table('users')->insert([
        //     'fullname'   => $request->fullname,
        //     'username'   => $request->username,
        //     'email'      => $request->email,
        //     'password'   => bcrypt($request->password),
        //     'phone'      => $request->phone,
        //     'address'    => $request->address,
        //     'role'       => $request->role,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
        // ==================================================================

        // ===================== LAB 07 - Eloquent ORM =====================
        try {
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'phone'    => $request->phone,
                'address'  => $request->address,
                'role'     => $request->input('role', 2),
                'status'   => $request->input('status', 1),
            ]);
            return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi thêm mới: ' . $e->getMessage());
        }
        // =================================================================
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::find($id);
            $data = [
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'role'     => $request->input('role', 2),
                'status'   => $request->input('status', 1),
            ];
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }
            $user->update($data);
            return redirect()->route('admin.users.index')->with('success', 'Sửa người dùng thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (auth()->id() == $id) {
                return redirect()->back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình.');
            }
            User::findOrFail($id)->delete();
            return redirect()->route('admin.users.index')->with('success', 'Xóa mềm người dùng thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thực hiện xóa mềm thất bại: ' . $e->getMessage());
        }
    }

    public function trash(Request $request)
    {
        $limit = $request->input('limit', 10);
        $list = User::onlyTrashed()->orderBy('fullname')->paginate($limit);
        return view('admin.users.trash', compact('list'));
    }

    public function restore($id)
    {
        try {
            User::onlyTrashed()->findOrFail($id)->restore();
            return redirect()->route('admin.users.trash')->with('success', 'Khôi phục người dùng thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục thất bại: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            User::onlyTrashed()->findOrFail($id)->forceDelete();
            return redirect()->route('admin.users.trash')->with('success', 'Xóa vĩnh viễn người dùng thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn thất bại: ' . $e->getMessage());
        }
    }
}
