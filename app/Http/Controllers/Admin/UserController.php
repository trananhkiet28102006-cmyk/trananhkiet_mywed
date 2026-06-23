<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function store(Request $request)
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
    public function update(Request $request, string $id)
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
        //
    }
}
