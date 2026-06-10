<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $role = $request->input('role');
        $users = User::query()
            ->when($role !== null && $role !== '', fn ($query) => $query->where('role', (int) $role))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'role'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'integer', 'in:0,1,2'],
        ]);

        User::findOrFail($id)->update(['role' => (int) $validated['role']]);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }
}
