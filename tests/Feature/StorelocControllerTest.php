<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Mockery;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Interfaces\StoreRepositoryInterface;

class StorelocControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function index_displays_index_view_with_services(): void
    {
        Service::factory()->count(3)->create();

        $response = $this->get(route('index'));

        $response->assertStatus(200);
        $response->assertViewIs('index');
        $response->assertViewHas('services', function ($services) {
            return $services->count() === 3;
        });
    }

    /** @test */
    public function results_calls_repository_and_returns_results_view(): void
    {
        $services = Service::factory()->count(2)->create();

        $mockRepository = Mockery::mock(StoreRepositoryInterface::class);
        $this->app->instance(StoreRepositoryInterface::class, $mockRepository);

        $stores = collect([
            Store::factory()->make([
                'id' => 1,
                'name' => 'Store 1',
                'address' => '1 Rue Test',
                'zipcode' => '75001',
                'city' => 'Paris',
                'country_code' => 'FR',
            ])->setRelation('services', $services),

            Store::factory()->make([
                'id' => 2,
                'name' => 'Store 2',
                'address' => '2 Rue Test',
                'zipcode' => '69001',
                'city' => 'Lyon',
                'country_code' => 'FR',
            ])->setRelation('services', $services),
        ]);

        $mockRepository
            ->shouldReceive('search')
            ->once()
            ->andReturn($stores);

        $response = $this->get(route('results', [
            'n' => 50,
            's' => -5,
            'e' => 10,
            'w' => -10,
            'services' => $services->pluck('id')->toArray(),
            'operator' => 'AND',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('results');
        $response->assertViewHas('stores', $stores);
    }

    /** @test */
    public function results_uses_default_values_when_services_are_missing(): void
    {
        $mockRepository = Mockery::mock(StoreRepositoryInterface::class);
        $this->app->instance(StoreRepositoryInterface::class, $mockRepository);

        $expectedStores = collect([]);

        $mockRepository
            ->shouldReceive('search')
            ->once()
            ->andReturn($expectedStores);

        $response = $this->get(route('results', [
            'n' => 50,
            's' => -5,
            'e' => 10,
            'w' => -10,
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('results');
        $response->assertViewHas('stores', $expectedStores);
    }
}
