<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public function dashboard()
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Ambil nilai remaining_days dari tabel users berdasarkan pengguna yang login
    $cutiSisa = $user->remaining_day; // Asumsi 'remaining_days' adalah kolom di tabel 'users'

    // Menampilkan dashboard
    return view('pages.App.dashboard', compact('cutiSisa'));
}
public function index(Request $request)
{
    // Ambil data pengguna yang sedang login
    $user = Auth::user();

    // Ambil data pengguna untuk tabel, ini untuk pagination
    $users = DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    // Ambil remaining_days dari pengguna yang sedang login
    $cutiSisa = $user->remaining_day; // Mengambil nilai remaining_days dari pengguna yang sedang login

    return view('pages.user.index', compact('users', 'cutiSisa'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           
            'email' => 'required|email|unique:users',
            
        ]);
   

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
            'remaining_day' => $request['remaining_day'],
           
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
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
    public function edit(User $user)
    {
        return view('pages.user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserStore $request, User $user)
    {
        $validate = $request->validated();
        $user->update($validate);

       return redirect()->route('user.index')->with('success', 'Data anda berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
         $user->delete();
       
       return redirect()->route('user.index')->with('success', 'Data anda berhasil di hapus');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
