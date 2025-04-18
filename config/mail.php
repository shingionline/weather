<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => 'smtp.postmarkapp.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => 'c710ac33-3aa6-4878-8d56-cde7a20caf10',
            'password' => 'c710ac33-3aa6-4878-8d56-cde7a20caf10',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'cpanel' => [
            'transport' => 'smtp',
            'host' => 'cp54.domains.co.za',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'info@overshop.co.za',
            'password' => 'M.ush1p3',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'amelia' => [
            'transport' => 'smtp',
            'host' => 'cp54.domains.co.za',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'amelia.davies@overshop.co.za',
            'password' => 'M.ush1p3',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'gmail' => [
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'shingi2009@gmail.com',
            'password' => 'rmrcfybipkccsjpi',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'overshopmailer' => [
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'hello@overshopmailer.com',
            'password' => 'inlycfxwjbgsdnjz',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'overshop' => [
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'hello@overshop.com',
            'password' => 'ahlpqhwamsswzeji ',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'mailtrap' => [
            'transport' => 'smtp',
            'host' => 'sandbox.smtp.mailtrap.io',
            'port' => 2525,
            'encryption' => 'tls',
            'username' => '318f09fe29e7fe',
            'password' => '2d8ecb35e71193',
            'timeout' => null,
            'auth_mode' => null,
            'verify_peer' => false,
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    // 'stream' => [
    //     'ssl' => [
    //        'allow_self_signed' => true,
    //        'verify_peer' => false,
    //        'verify_peer_name' => false,
    //     ],
    //  ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
