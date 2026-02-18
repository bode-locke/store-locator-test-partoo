<?php

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\Store;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\StoreRepository;
use Illuminate\Support\Facades\Cache;

class StoreRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected StoreRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new StoreRepository();
    }

    /** @test */
    public function search_returns_stores_within_bounds(): void
    {
        Store::factory()->create([
            'lat' => 48.8566,
            'lng' => 2.3522,
        ]);

        Store::factory()->create([
            'lat' => 51.5074,
            'lng' => -0.1278,
        ]);

        $stores = $this->repository->search(
            50.0,
            48.0,
            3.0,
            2.0
        );

        $this->assertCount(1, $stores);
        $this->assertEquals(48.8566, $stores->first()->lat, 0.001);
    }

    /** @test */
    public function search_filters_by_services_with_or_operator(): void
    {
        $serviceA = Service::factory()->create();
        $serviceB = Service::factory()->create();

        $store1 = Store::factory()->create();
        $store2 = Store::factory()->create();

        $store1->services()->attach([$serviceA->id]);
        $store2->services()->attach([$serviceB->id]);

        $stores = $this->repository->search(
            90, -90, 180, -180,
            [$serviceA->id, $serviceB->id],
            'OR'
        );

        $this->assertCount(2, $stores);
    }

    /** @test */
    public function search_filters_by_services_with_and_operator(): void
    {
        $serviceA = Service::factory()->create();
        $serviceB = Service::factory()->create();

        $store1 = Store::factory()->create();
        $store2 = Store::factory()->create();

        $store1->services()->attach([$serviceA->id, $serviceB->id]);
        $store2->services()->attach([$serviceA->id]);

        $stores = $this->repository->search(
            90, -90, 180, -180,
            [$serviceA->id, $serviceB->id],
            'AND'
        );

        $this->assertCount(1, $stores);
        $this->assertEquals($store1->id, $stores->first()->id);
    }

    /** @test */
    public function find_with_services_returns_store_from_cache(): void
    {
        $store = Store::factory()->create();
        $service = Service::factory()->create();
        $store->services()->attach($service->id);

        Cache::shouldReceive('remember')
            ->once()
            ->with("store_{$store->id}", 600, \Closure::class)
            ->andReturn($store);

        $result = $this->repository->findWithServices($store->id);

        $this->assertEquals($store->id, $result->id);
        $this->assertNotEmpty($result->services);
    }
}
