<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Store;

/**
 * @template-implements StoreRepositoryInterface
 */
interface StoreRepositoryInterface
{
    /**
     * @param float $north
     * @param float $south
     * @param float $east
     * @param float $west
     * @param int[] $serviceIds
     * @param string $operator
     * @return Collection<int, Store>
     */
    public function search(
        float $north,
        float $south,
        float $east,
        float $west,
        array $serviceIds = [],
        string $operator = 'OR'
    ): Collection;

    /**
     * @param int $id
     * @return Store
     */
    public function findWithServices(int $id): Store;
}
