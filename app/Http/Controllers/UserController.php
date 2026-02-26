<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Role};
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        return redirect()->route('users.index')->with('success', 'User deleted successfully (Static Mock).');
    }

    public function roles()
    {
        $roles = Role::withCount('users')->get();

        return view('users.roles', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        return redirect()->route('users.roles')->with('success', 'Role created successfully (Static Mock).');
    }

    public function destroyRole($id)
    {
        return redirect()->route('users.roles')->with('success', 'Role deleted successfully (Static Mock).');
    }
}
