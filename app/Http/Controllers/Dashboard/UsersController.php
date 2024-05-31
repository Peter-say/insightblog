<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(30);
        return view('dashboard.users.index', ['users'=> $users]);
    }

    public function updateRole(Request $request, User $user)
    {
      
        $request->validate([
            'role' => 'required|in:Admin,Moderator,Author,User',
        ]);
        $user->update(['role' => $request->role]);
        return back()->with('success_message', 'User role updated successfully.');
    }

    public function destroy(string $id)
    {
      $user = User::findOrFail($id);
      $user->delete();
      return back()->with('success_message', 'User Removed Successfully');
    }
}
