<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    protected $fillable = [
        'menu_name',
        'menu_route',
        'menu_icon',
        'menu_label',
        'role',
        'is_active',
        'order',
        'can_create',
        'can_read',
        'can_update',
        'can_delete',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'can_create' => 'boolean',
        'can_read' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
    ];

    /**
     * Get active menus for a specific role
     */
    public static function getActiveMenus($role)
    {
        return self::where('role', $role)
                   ->where('is_active', true)
                   ->orderBy('order')
                   ->get();
    }

    /**
     * Get all menus grouped by role
     */
    public static function getAllMenusGrouped()
    {
        return self::orderBy('role')
                   ->orderBy('order')
                   ->get()
                   ->groupBy('role');
    }
}
