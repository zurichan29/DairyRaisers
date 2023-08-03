<?php
// app/Helpers/AdminHelper.php

namespace App\Helpers;

class AdminHelper
{
    public static function getSidebarAccess($admin)
    {
        // Convert the admin's access to an array if it's not already an array
        $adminAccess = is_array($admin->access) ? $admin->access : json_decode($admin->access, true);

        // Define the access options for the sidebar
        $sidebarAccess = [
            'inventory' => 'Inventory',
            'orders' => 'Orders',
            'products' => 'Product Management',
            'payment_methods' => 'Payment Methods',
            'buffalos_and_milk' => 'Buffalos & Milk',
            'staff_management' => 'Staff Management',
            'activity_logs' => 'Activity Logs',
        ];

        $accessibleLinks = [];

        foreach ($sidebarAccess as $key => $label) {
            if (in_array($key, $adminAccess)) {
                $accessibleLinks[$key] = $label;
            }
        }

        return $accessibleLinks;
    }
}
