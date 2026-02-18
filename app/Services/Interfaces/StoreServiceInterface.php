<?php

namespace App\Services\Interfaces;

use App\Models\Store;

/**
 * Interface for store-related service operations.
 */
interface StoreServiceInterface
{
    /**
     * Determines if a given store is currently open.
     *
     * @param Store $store
     * @return bool
     */
    public function isOpen(Store $store): bool;
}
