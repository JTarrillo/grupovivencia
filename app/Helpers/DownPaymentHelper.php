<?php
namespace App\Helpers;

class DownPaymentHelper
{
    /**
     * Calcula la cuota inicial mínima según tipo y parámetros
     * @param float $lot_price Precio total del lote
     * @param string $type 'percentage' o 'fixed'
     * @param float $percentage Valor del porcentaje mínimo (si aplica)
     * @param float $fixed Valor fijo mínimo (si aplica)
     * @return float Cuota inicial mínima calculada
     */
    public static function calculateMinDownPayment($lot_price, $type = 'percentage', $percentage = 0, $fixed = 0)
    {
        if ($type === 'percentage') {
            return round($lot_price * ($percentage / 100), 2);
        } else {
            return round($fixed, 2);
        }
    }

    /**
     * Valida si la cuota inicial ingresada cumple el mínimo
     * @param float $down_payment Cuota inicial ingresada
     * @param float $min_down_payment Cuota inicial mínima calculada
     * @return bool
     */
    public static function isValidDownPayment($down_payment, $min_down_payment)
    {
        return $down_payment >= $min_down_payment;
    }
}
