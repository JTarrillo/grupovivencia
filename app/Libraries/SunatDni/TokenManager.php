<?php
namespace App\Libraries\SunatDni;

use Config\SunatTokens;

class TokenManager
{
    private $tokens = [];
    private $currentIndex = 0;
    private $usage = [];
    private $limit = 950; // Cambia según el límite real de la API

    public function __construct()
    {
        $config = new SunatTokens();
        $this->tokens = $config->tokens;
        foreach ($this->tokens as $i => $token) {
            $this->usage[$i] = 0;
        }
        // Si el límite se configura en SunatTokens, úsalo
        if (property_exists($config, 'limit')) {
            $this->limit = $config->limit;
        }
    }

    public function getToken()
    {
        // Buscar token disponible
        foreach ($this->tokens as $i => $token) {
            if ($this->usage[$i] < $this->limit) {
                $this->currentIndex = $i;
                return $token;
            }
        }
        return null; // No hay tokens disponibles
    }

    public function incrementUsage()
    {
        $this->usage[$this->currentIndex]++;
    }

    public function resetUsage($index)
    {
        $this->usage[$index] = 0;
    }

    public function getUsage()
    {
        return $this->usage;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
}
