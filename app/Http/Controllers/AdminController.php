<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RequestStoreOrUpdateUser;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
        {
            $admins = User::whereIn('role', ['admin', 'masteradmin', 'teknisi'])
                        ->orderByDesc('id')
                        ->paginate(10);
            return view('dashboard.data-admin.index', compact('admins'));
        }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.data-admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreOrUpdateUser $request)
    {
        $validated = $request->validated() + [
            'created_at' => now(),
        ];
        $validated['password'] = Hash::make($request->password);

        // if($request->hasFile('avatar')){
        //     $fileName = time() . '.' . $request->avatar->extension();
        //     $validated['avatar'] = $fileName;

        //     // move file
        //     $request->avatar->move(public_path('uploads/images'), $fileName);
        // }

        $admin = User::create($validated);

        return redirect(route('data-admin.index'))->with('success', 'Data Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = User::findOrFail($id);

        return view('dashboard.data-admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestStoreOrUpdateUser $request, $id)
    {
        $validated = $request->validated() + [
            'updated_at' => now(),
        ];

        $admin = User::findOrFail($id);

        $validated['avatar'] = $admin->avatar;

        if($request->hasFile('avatar')){
            $fileName = time() . '.' . $request->avatar->extension();
            $validated['avatar'] = $fileName;

            // move file
            $request->avatar->move(public_path('uploads/images'), $fileName);

            // delete old file
            $oldPath = public_path('/uploads/images/'.$admin->avatar);
            if(file_exists($oldPath) && $admin->avatar != 'avatar.png'){
                unlink($oldPath);
            }
        }

        $admin->update($validated);

        return redirect(route('data-admin.index'))->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        // delete old file
        $oldPath = public_path('/uploads/images/'.$admin->avatar);
        if(file_exists($oldPath) && $admin->avatar != 'avatar.png'){
            unlink($oldPath);
        }
        $admin->delete();

        return redirect(route('data-admin.index'))->with('success', 'Data admin berhasil dihapus.');
    }
}
