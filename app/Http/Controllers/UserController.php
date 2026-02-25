<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $users = collect([
            (object)['id' => 1, 'name' => 'Admin User', 'email' => 'admin@crm.com', 'status' => 'active', 'role' => (object)['name' => 'Admin'], 'created_at' => now()->subMonths(6)],
            (object)['id' => 2, 'name' => 'Agent Smith', 'email' => 'smith@crm.com', 'status' => 'active', 'role' => (object)['name' => 'Agent'], 'created_at' => now()->subMonths(2)],
        ]);

        $roles = collect([(object)['id' => 1, 'name' => 'Admin'], (object)['id' => 2, 'name' => 'Agent']]);

        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        return redirect()->route('users.index')->with('success', 'User created successfully (Static Mock).');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('users.index')->with('success', 'User updated successfully (Static Mock).');
    }

    public function destroy($id)
    {
        return redirect()->route('users.index')->with('success', 'User deleted successfully (Static Mock).');
    }

    public function roles()
    {
        $roles = collect([
            (object)['id' => 1, 'name' => 'Admin', 'users_count' => 1, 'permissions' => ['*']],
            (object)['id' => 2, 'name' => 'Agent', 'users_count' => 5, 'permissions' => ['leads.view', 'leads.edit']],
        ]);

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

