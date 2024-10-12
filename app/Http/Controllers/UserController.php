<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
       public function index(Request $request)
    {
        $users = DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })
        //->select('id', 'name', 'email', 'phone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as created_at'))
        ->orderBy('id', 'desc')
        ->paginate(10);


        
        return view('pages.user.index' , compact('users'));
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
            'name' => 'required|max:100|min:3',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:8',
            'role' => 'required|in:ADMIN,ATASAN,KARYAWAN',
            'remaining_day' => 'required|integer|min:0',
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
}
