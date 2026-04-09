<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use App\Filters\AuthGuard;
use App\Filters\AuthAdmin;  // <-- agrega esto

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'      => CSRF::class,
        'toolbar'   => DebugToolbar::class,
        'honeypot'  => Honeypot::class,
        'authGuard' => AuthGuard::class,
        'authAdmin' => AuthAdmin::class,  
    ];

    public $globals = [
        'before' => [],
        'after' => [
            'toolbar',
        ],
    ];

    public $methods = [];
    public $filters = [];
}