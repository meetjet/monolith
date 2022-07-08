<?php

use App\Enums\Role;

return [
    Role::class => [
        Role::ROOT => 'Супер администратор',
        Role::ADMIN => 'Администратор',
        Role::MANAGER => 'Менеджер',
        Role::EDITOR => 'Редактор',
        Role::SUBSCRIBER => 'Подписчик',
    ],
];
