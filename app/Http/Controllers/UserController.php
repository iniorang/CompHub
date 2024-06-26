<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$roles = Role::pluck('name','name')->all();
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'password' => $input['password']
        ]);

        return redirect()->route('index')->with('success', 'User terbuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorfail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|',
            'password',
            'alamat',
            'telp',
        ]);

        $user = User::findorfail($id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'password' => $input['password']
        ]);

        return redirect()->route('index')->with('success', 'User terubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = user::findOrFail($id);
        $user->forceDelete();
        return redirect()->route('index')->with(['success' => 'Data User dihapus']);
    }

    public function editprofile($id)
    {
        $user = User::findorfail($id);
        return view('profile', compact('user'));
    }

    public function updateProfil(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|',
            //'password',
            'alamat',
            'telp',
        ]);

        $user = User::findorfail($id);
        $input = $request->all();
        //$input['password'] = Hash::make($input['password']);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            //'password' => $input['password']
        ]);

        return redirect()->route('profile', ['id' => $user->id])->with('success', 'Profile sudah terbarui');
    }

    public function disableUser($id)
    {
        $user = User::findOrFail($id);
        $user->disabled = true;
        $user->save();

        return redirect()->route('listdisabled')->with('success', 'Akun Sudah dimatikan.');
    }

    public function listDisabledUsers()
    {
        $disabledUsers = User::where('disabled', true)->get();
        return view('user.disabled_list', compact('disabledUsers'));
    }

    public function reactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->disabled = false;
        $user->save();

        return redirect()->route('listdisabled')->with('success', 'Akun dihidupkan kembali.');
    }

    public function destroyUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.disabled')->with('success', 'User permanently deleted.');
    }

    public function deactivate(Request $request)
    {
        // Nonaktifkan akun
        Auth::user()->update([
            'disabled' => true,
        ]);
        Auth::logout();

        // Redirect ke halaman login
        return redirect()->route('beranda')->with('status', 'Your account has been deactivated.');
    }

    public function deactivationForm()
    {
        return view('matikanakun');
    }
}
