<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class SunatTokens extends BaseConfig
{
    // Agrega aquí tus 10 tokens
    public $tokens = [
        'sk_11083.sR4YHfncmIOSMN8ERNhxI1d1LL2CSSSH',
        // Agrega aquí tus otros tokens
    ];
    public $limit = 950; // Límite de consultas por token
    public $endpoint = 'https://api.decolecta.com/v1/reniec/dni';
}