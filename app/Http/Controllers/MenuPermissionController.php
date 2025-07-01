<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuPermission;

class MenuPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = MenuPermission::getAllMenusGrouped();
        return view('menu_permissions.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = ['admin', 'guru', 'siswa'];
        return view('menu_permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_route' => 'required|string|max:255',
            'menu_icon' => 'nullable|string|max:100',
            'menu_label' => 'required|string|max:255',
            'role' => 'required|in:admin,guru,siswa',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
            'can_create' => 'nullable|boolean',
            'can_read' => 'nullable|boolean',
            'can_update' => 'nullable|boolean',
            'can_delete' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['can_create'] = $request->has('can_create') ? 1 : 0;
        $data['can_read'] = $request->has('can_read') ? 1 : 0;
        $data['can_update'] = $request->has('can_update') ? 1 : 0;
        $data['can_delete'] = $request->has('can_delete') ? 1 : 0;

        MenuPermission::create($data);

        return redirect()->route('menu-permissions.index')
            ->with('success', 'Menu permission berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuPermission $menuPermission)
    {
        return view('menu_permissions.show', compact('menuPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuPermission $menuPermission)
    {
        $roles = ['admin', 'guru', 'siswa'];
        return view('menu_permissions.edit', compact('menuPermission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuPermission $menuPermission)
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_route' => 'required|string|max:255',
            'menu_icon' => 'nullable|string|max:100',
            'menu_label' => 'required|string|max:255',
            'role' => 'required|in:admin,guru,siswa',
            'is_active' => 'nullable|boolean',
            'order' => 'required|integer|min:0',
            'can_create' => 'nullable|boolean',
            'can_read' => 'nullable|boolean',
            'can_update' => 'nullable|boolean',
            'can_delete' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['can_create'] = $request->has('can_create') ? 1 : 0;
        $data['can_read'] = $request->has('can_read') ? 1 : 0;
        $data['can_update'] = $request->has('can_update') ? 1 : 0;
        $data['can_delete'] = $request->has('can_delete') ? 1 : 0;

        $menuPermission->update($data);

        return redirect()->route('menu-permissions.index')
            ->with('success', 'Menu permission berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuPermission $menuPermission)
    {
        $menuPermission->delete();

        return redirect()->route('menu-permissions.index')
            ->with('success', 'Menu permission berhasil dihapus.');
    }

    /**
     * Toggle menu active status
     */
    public function toggleStatus(MenuPermission $menuPermission)
    {
        $menuPermission->update([
            'is_active' => !$menuPermission->is_active
        ]);

        $status = $menuPermission->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('menu-permissions.index')
            ->with('success', "Menu {$menuPermission->menu_label} berhasil {$status}.");
    }
}
