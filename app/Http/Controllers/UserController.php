<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($role){
        return view('users.index');
    }

    public function data($role){
        $datas = User::role($role)->get();

        foreach ($datas as $data) {
                $options = '';

                if (auth()->user()->can('edit_users')) {
                    $options = $options ."<a href='". route('users.edit', ['role' => $role, 'id' => $data->id]) ."' class='btn btn-warning mx-2'>Edit</a>";
                }
                
                if (auth()->user()->can('delete_users')) {
                    $options = $options . "<button class='btn btn-danger mx-2' onclick='deleteData(`". route('users.destroy', ['role' => $role, 'id' => $data->id]) ."`)'>
                                        Hapus
                                    </button>";

                $data->options = $options;
            }
        }

        return DataTables::of($datas)
                            ->addIndexColumn()
                            ->rawColumns(['options'])
                            ->make(true);
    }

    public function create(){
        return view('users.form');
    }

    public function store(Request $request, $role){
        $request->validate([
            'email' => 'required|unique:users',
            'name' => 'required',
        ], [
            'email.required' => ($role == 'petugas' ? 'The NIP field is required.' : 'The NIS field is required.'),
            'email.unique' => ($role == 'petugas' ? 'The NIP is already in use.' : 'The NIS is already in use.'),
            'name.required' => 'The nama field is required.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('000000')
        ]);

        $user->assignRole($role);

        return redirect()->route('users.index', ['role' => $role])->with('success', 'Berhasil ditambahkan');
    }

    public function edit($role, $id){
        $data = User::findOrFail($id);
        return view('users.form', compact('data'));
    }

    public function update(Request $request, $role, $id){
        $request->validate([
            'email' => 'required|unique:users,email,' . $id,
            'name' => 'required',
        ], [
            'email.required' => ($role == 'petugas' ? 'The NIP field is required.' : 'The NIS field is required.'),
            'email.unique' => ($role == 'petugas' ? 'The NIP is already in use.' : 'The NIS is already in use.'),
            'name.required' => 'The nama field is required.'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('users.index', ['role' => $role])->with('success', 'Berhasil diubah');
    }
}
