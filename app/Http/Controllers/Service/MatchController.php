<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Filters\FilterMatchRequest;
use App\Service\MatchService;
use Exception;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class MatchController extends Controller
{

    /**
     * @var MatchService $matchService
     */
    private MatchService $matchService;

    /**
     * __construct()
     */
    public function __construct()
    {
        $this->matchService = new MatchService();
    }

    /**
     * index
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->matchService->getInitialList());
    }

    /**
     * show
     * @param int|string $matchId
     * @return Response
     */
    public function show(int|string $matchId) : Response
    {
        return Inertia::render('Details/MatchDetails', [
            'matchDetails' => $this->matchService->getMatchDetails($matchId)
        ]);
    }

    /**
     * search
     * @param FilterMatchRequest $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function filter(FilterMatchRequest $filters) : JsonResponse
    {
        return response()->json($this->matchService->search($filters));
    }
}
