<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Models\Store;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\StoreRepository;
use App\Services\Interfaces\StoreServiceInterface;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function show_displays_store_view_with_services_and_open_status(): void
    {
        $services = Service::factory()->count(2)->create();

        $store = Store::factory()->make([
            'id' => 1,
            'name' => 'Store 1',
            'address' => '1 Rue Test',
            'zipcode' => '75001',
            'city' => 'Paris',
            'country_code' => 'FR',
            'hours' => json_encode([
                'Monday' => ['09:00-12:00', '14:00-18:00'],
            ]),
        ])->setRelation('services', $services);

        $mockRepository = Mockery::mock(StoreRepository::class);
        $mockRepository->shouldReceive('findWithServices')
            ->once()
            ->with($store->id)
            ->andReturn($store);
        $this->app->instance(StoreRepository::class, $mockRepository);

        $mockService = Mockery::mock(StoreServiceInterface::class);
        $mockService->shouldReceive('isOpen')
            ->once()
            ->with($store)
            ->andReturn(true);
        $this->app->instance(StoreServiceInterface::class, $mockService);

        $response = $this->get(route('store.show', $store->id));

        $response->assertStatus(200);
        $response->assertViewIs('store.show');
        $response->assertViewHas('store', $store);
        $response->assertViewHas('isOpen', true);

        $response->assertSeeText($services[0]->name);
        $response->assertSeeText($services[1]->name);

        $response->assertSeeText('Store 1');

        $response->assertSeeText('Oui');
    }
}
