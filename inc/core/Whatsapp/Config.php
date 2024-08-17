<?php
return [
    'id' => 'whatsapp',
    'folder' => 'core',
    'name' => 'Report',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'desc' => 'Customize system interface',
    'icon' => 'fab fa-whatsapp',
    'color' => '#25d366',
    'parent' => [
        "id" => "features",
        "name" => "Features"
    ],
    'menu' => [
        'tab' => 2,
        'type' => 'top',
        'position' => 1000,
        'name' => 'Whatsapp'
    ],
    "js" => [
        'Assets/js/whatsapp.js'
    ],
];