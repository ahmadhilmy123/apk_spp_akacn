<?php

use Spatie\Permission\Models\Role;

if (!function_exists('getRoleWithout')) {

    function getRoleWithout($except=[])
    {
        return Role::whereNotIn('name', $except)->get();
    }
}