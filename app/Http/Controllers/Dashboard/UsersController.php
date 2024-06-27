<?php

namespace App\Http\Controllers\Dashboard;

use App\Constants\StatusConstants;
use App\Helpers\FileHelpers;
use App\Http\Controllers\Controller;
use App\Mail\UserLoginDetailsMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index(User $user)
    {
        $this->authorize('view', $user);
        $users = User::paginate(30);
        return view('dashboard.users.index', ['users'=> $users]);
    }

    public function create()
    {
         $userRoles = StatusConstants::USERS_ROLE;
         return view('dashboard.users.add', compact('userRoles'));
    }
    public function validateUser(Request $request, $id)
    {
        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($id ? $id : 'NULL'),
            'role' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);
    }
    public function store(Request $request, $id = null)
    {
        $this->validateUser($request, $id);
        // Handle file upload for avatar
        $avatarFileName = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = FileHelpers::saveImageRequest($request->file('avatar'), 'users/avatar');
            $avatarFileName = basename($avatarPath);
        }

        // Generate a random password
        $randomPassword = Str::random(12);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->password = Hash::make($randomPassword);
        $user->save();

        $this->sendLoginDetails($user->id);

        return redirect()->route('dashboard.users')->with('success_message', 'User added successfully.');

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

    public function sendLoginDetails($userId)
    {
        try {
            $user = User::findOrFail($userId);

            $randomPassword = Str::random(12);

            $user->password = Hash::make($randomPassword);
            $user->save();

            Mail::to($user->email)->send(new UserLoginDetailsMail($user, $randomPassword));

            return back()->with('success_message', 'Login details resent Successfully');
        } catch (Exception  $e) {
            return redirect()->back()->with('error_message', 'An error occurred while updating the user.'. $e->getMessage());
        }
    }

    public function verifyEmail(Request $request, $id)
{
    $user = User::findOrFail($id);

    if ($request->has('email_verified')) {
        $user->email_verified_at = $request->input('email_verified') ? Carbon::now() : null;
    }

    $user->save();

    return redirect()->back()->with('success_message', 'User email verification status updated successfully.');
}
}
