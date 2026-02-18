<?php

namespace App\Services;

use App\Models\Store;
use App\Services\Interfaces\StoreServiceInterface;
use Carbon\Carbon;

/**
 * Service handling store status operations.
 */
class StoreService implements StoreServiceInterface
{
    /**
     * Determines if a store is currently open based on its hours.
     *
     * @param Store $store
     * @return bool
     */
    public function isOpen(Store $store): bool
    {
        $hours = json_decode($store->hours, true);
        $timezone = config('app.timezone', 'Europe/Paris');

        $today = Carbon::now($timezone)->format('l');
        $now = Carbon::now($timezone);

        if (empty($hours[$today])) {
            return false;
        }

        foreach ($hours[$today] as $interval) {
            [$start, $end] = explode('-', $interval);

            $startTime = Carbon::today($timezone)->setTimeFromTimeString($start);
            $endTime = Carbon::today($timezone)->setTimeFromTimeString($end);

            if ($now->between($startTime, $endTime)) {
                return true;
            }
        }

        return false;
    }


}
