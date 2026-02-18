<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $address
 * @property string $city
 * @property string $zipcode
 * @property string $country_code
 * @property array $hours
 * @property Collection<int, Service> $services
 */
class Store extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'lat',
        'lng',
        'address',
        'city',
        'zipcode',
        'country_code',
        'hours',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'hours' => 'array',
    ];

    /**
     * @return BelongsToMany<Service>
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
