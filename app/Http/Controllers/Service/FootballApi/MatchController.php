<?php

namespace App\Http\Controllers\Service\FootballApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Filters\FilterMatchRequest;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{

    /**
     * index
     * @param int $matchId
     * @return mixed
     */
    public function index(int $matchId)
    {
        return $this->footballApiClient
            ->getMatchById($matchId)
            ->request();
    }

    /**
     * search
     * @param FilterMatchRequest $filters
     * @return JsonResponse
     * @throws \Exception
     */
    public function search(FilterMatchRequest $filters): JsonResponse
    {
        // 7-day differences are added by default if dates are null
        if ($filters['dateFrom'] === null && $filters['dateTo'] === null) {
            $filters['dateFrom'] = (new \DateTime('-6 days'))->format('Y-m-d');
            $filters['dateTo'] = (new \DateTime())->format('Y-m-d');

        } else if ($filters['dateFrom'] === null && $filters['dateTo'] !== null) {
            $filters['dateFrom'] = (new \DateTime($filters['dateTo'] . ' -6 days'))->format('Y-m-d');

        } else if ($filters['dateFrom'] !== null && $filters['dateTo'] === null) {
            $filters['dateTo'] = (new \DateTime($filters['dateFrom'] . ' +6 days'))->format('Y-m-d');
        }

        return response()->json($this->footballApiClient
            ->getMatches($filters->all())
            ->request());
    }
}
