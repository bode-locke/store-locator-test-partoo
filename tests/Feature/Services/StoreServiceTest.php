<?php

namespace Tests\Feature\Feature\Services;

use Tests\TestCase;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class StoreServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StoreService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StoreService();
    }

    /** @test */
    public function it_returns_true_when_store_is_open(): void
    {
        // On fixe la date/heure pour être sûr du test
        Carbon::setTestNow(Carbon::create(2026, 2, 17, 10, 0)); // mardi 10h00

        $hours = [
            'Tuesday' => ['09:00-18:00'],
        ];

        $store = Store::factory()->create([
            'hours' => json_encode($hours),
        ]);

        $this->assertTrue($this->service->isOpen($store));
    }

    /** @test */
    public function it_returns_false_when_store_is_closed(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 2, 17, 20, 0)); // mardi 20h00

        $hours = [
            'Tuesday' => ['09:00-18:00'],
        ];

        $store = Store::factory()->create([
            'hours' => json_encode($hours),
        ]);

        $this->assertFalse($this->service->isOpen($store));
    }

    /** @test */
    public function it_returns_false_when_store_has_no_hours_for_today(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 2, 17, 12, 0)); // mardi midi

        $hours = [
            'Monday' => ['09:00-18:00'], // pas de mardi
        ];

        $store = Store::factory()->create([
            'hours' => json_encode($hours),
        ]);

        $this->assertFalse($this->service->isOpen($store));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow(); // réinitialise Carbon
        parent::tearDown();
    }
}
