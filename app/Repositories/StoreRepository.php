<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

/**
 * @implements StoreRepositoryInterface
 */
class StoreRepository implements StoreRepositoryInterface
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
    ): Collection {

        return Store::query()
            ->with('services')
            ->whereBetween('lat', [$south, $north])
            ->whereBetween('lng', [$west, $east])
            ->when(
                !empty($serviceIds),
                fn (Builder $query) => $this->applyServiceFilter($query, $serviceIds, $operator)
            )
            ->get();
    }

    /**
     * @param int $id
     * @return Store
     */
    public function findWithServices(int $id): Store
    {
        return Cache::remember(
            "store_{$id}",
            600,
            fn (): Store => Store::with('services')->findOrFail($id)
        );
    }

    /**
     * @param Builder $query
     * @param int[] $serviceIds
     * @param string $operator
     * @return Builder
     */
    private function applyServiceFilter(
        Builder $query,
        array $serviceIds,
        string $operator
    ): Builder {
        return $query->whereHas(
            'services',
            fn (Builder $q) => $q->whereIn('services.id', $serviceIds),
            $operator === 'AND' ? '=' : '>=',
            $operator === 'AND' ? count($serviceIds) : 1
        );
    }
}
