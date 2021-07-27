<?php

return [
    'adminka' => [
        'type' => 2,
        'description' => 'Админка',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'userRole',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'adminka',
        ],
    ],
];
