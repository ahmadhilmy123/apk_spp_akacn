<?php

use Spatie\Permission\Models\Role;

if (!function_exists('getRoleWithout')) {

    function getRoleWithout($except=[])
    {
        return Role::whereNotIn('name', $except)->get();
    }
}

if (!function_exists('formatRupiah')) {

    function formatRupiah($data)
    {
        return 'Rp ' . number_format($data, 0, ',', '.'); 
    }
}