<?php

use App\Enums\Role;

return [
    Role::class => [
        Role::ROOT => 'Super administrator',
        Role::ADMIN => 'Administrator',
        Role::MANAGER => 'Manager',
        Role::EDITOR => 'Editor',
        Role::SUBSCRIBER => 'Subscriber',
    ],
];
