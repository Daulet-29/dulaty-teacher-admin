<?php

return [
    // Другие настройки Filament

    'middleware' => [
        'auth',
//        \App\Http\Middleware\CheckTeacherRole::class,
        'verified',
    ],
    'brand' => 'Ваш Заголовок', // Измените на нужное название

    'components' => [
        'header' => 'vendor.filament.components.header',
        'pages.dashboard' => 'vendor.filament.pages.dashboard',
    ],

    // Остальные настройки
];

