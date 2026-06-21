<?php

namespace App\Helpers;

class SaborXpressMenuHelper {
    /**
     * Filtra los elementos del menú por categoría
     */
    public static function filterByCategory($items, $categoryId) {
        $filtered = [];
        foreach ($items as $item) {
            if (isset($item['category_id']) && $item['category_id'] == $categoryId) {
                if (isset($item['is_active']) && $item['is_active']) {
                    $filtered[] = $item;
                }
            }
        }
        return $filtered;
    }

    /**
     * Calcula el precio con descuento aplicado para las promociones
     */
    public static function applyDiscount($price, $discountPercentage) {
        if ($discountPercentage <= 0 || $discountPercentage > 100) {
            return $price;
        }
        $discountAmount = $price * ($discountPercentage / 100);
        return round($price - $discountAmount, 2);
    }
}
