<?php
namespace App\Http\Controllers\Kelola;

use App\Http\Controllers\Controller;
use DataTables;
use App\Models\{
    User,
    TahunAjaran,
    Prodi,
    Mahasiswa
};
use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_users', ['only' => ['index', 'store']]);
        $this->middleware('permission:add_users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_users', ['only' => ['destroy']]);
    }

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

            }
            $data->options = $options;
        }

        return DataTables::of($datas)
                            ->addIndexColumn()
                            ->rawColumns(['options'])
                            ->make(true);
    }

    public function create($role){
        $return = [];

        if ($role == 'mahasiswa') {
            $tahun_ajarans = TahunAjaran::all();
            $prodis = Prodi::all();
            $return = [
                'tahun_ajarans' => $tahun_ajarans,
                'prodis' => $prodis
            ];
        }

        return view('users.form', $return);
    }

    public function store(Request $request, $role){
        $validate = [
            'email' => 'required|unique:users,email',
            'name' => 'required',
        ];

        if ($role == 'mahasiswa') {
            $validate['tahun_ajaran_id'] = 'required';
        }

        $request->validate($validate, [
            'email.required' => ($role == 'petugas' ? 'The NIP field is required.' : 'The NIM field is required.'),
            'email.unique' => ($role == 'petugas' ? 'The NIP is already in use.' : 'The NIM is already in use.'),
            'name.required' => 'The nama field is required.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('000000')
        ]);

        $user->assignRole($role);

        if ($role == 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->id,
                'prodi_id' => $request->prodi_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id
            ]);
        }

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
            'email.required' => ($role == 'petugas' ? 'The NIP field is required.' : 'The NIM field is required.'),
            'email.unique' => ($role == 'petugas' ? 'The NIP is already in use.' : 'The NIM is already in use.'),
            'name.required' => 'The nama field is required.'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('users.index', ['role' => $role])->with('success', 'Berhasil diubah');
    }

    public function destroy($role, $id){
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            if ($role == 'mahasiswa') {
                $user->mahasiswa->delete();
            }
            $user->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal dihapus');
        }
    }
}
