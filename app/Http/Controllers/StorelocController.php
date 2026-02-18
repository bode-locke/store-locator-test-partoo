<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSearchRequest;
use App\Models\Service;
use App\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\View\View;

class StorelocController extends Controller
{
    /**
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(protected StoreRepositoryInterface $storeRepository){
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('index', [
            'services' => Service::all(),
        ]);
    }

    /**
     * @param StoreSearchRequest $request
     * @return View
     */
    public function results(StoreSearchRequest $request): View
    {
        $data = $request->validated();

        $stores = $this->storeRepository->search(
            $data['n'],
            $data['s'],
            $data['e'],
            $data['w'],
            $data['services'] ?? [],
            $data['operator'] ?? 'OR'
        );

        return view('results', compact('stores'));
    }
}
