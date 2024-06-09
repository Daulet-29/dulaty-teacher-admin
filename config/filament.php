<?php

return [
    // Другие настройки Filament

    'middleware' => [
        'auth',
        \App\Http\Middleware\CheckTeacherRole::class,
        'verified',
    ],

    // Остальные настройки
];

