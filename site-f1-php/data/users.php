<?php

// Simulando banco de dados
return [
    [
        'username' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    [
        'username' => 'user',
        'password' => password_hash('user123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];