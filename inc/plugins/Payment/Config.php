<?php
return [
    'id' => 'payment',
    'folder' => 'plugins',
    'name' => 'Payment',
    'author' => 'Stackcode',
    'author_uri' => 'https://stackposts.com',
    'desc' => 'Customize system interface',
    'icon' => 'fad fa-credit-card',
    'color' => '#b3e200',
    'login_required' => false,
     'cron' => [
        'name' => 'Email Renewal reminders',
        'uri' => 'payment/cron',
        'style' => '* * * * *',
    ]
];