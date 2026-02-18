<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Repositories\StoreRepository;
use App\Services\Interfaces\StoreServiceInterface;
use Illuminate\View\View;

class StoreController extends Controller
{
    /**
     * Constructor.
     *
     * @param StoreRepository $storeRepository
     * @param StoreServiceInterface $storeService
     */
    public function __construct(
        private readonly StoreRepository $storeRepository,
        private readonly StoreServiceInterface $storeService
    ) {}

    /**
     * Show store details.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $store = $this->storeRepository->findWithServices($id);

        $isOpen = $this->storeService->isOpen($store);

        return view('store.show', compact('store', 'isOpen'));
    }
}
