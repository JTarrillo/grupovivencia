<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Session extends BaseConfig
{
    public string $driver = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $cookieName = 'ci_session';
    public int $expiration = 7200;
    public string $savePath = '';
    public bool $matchIP = false;
    public int $timeToUpdate = 300;
    public bool $regenerateDestroy = false;
    public string $cookiePath = '/';
    public string $cookieDomain = '';
    public bool $cookieSecure = false;

    public function __construct()
    {
        parent::__construct();

        $uri = $_SERVER['REQUEST_URI'] ?? '';

        $isAdmin = str_starts_with($uri, '/admin') || str_starts_with($uri, '/dashboard');

        if ($isAdmin) {
            $this->cookieName = 'ci_session_admin';
        } else {
            $this->cookieName = 'ci_session_backoffice';
        }
    }
}