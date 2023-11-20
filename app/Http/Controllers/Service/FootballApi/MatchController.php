<?php

namespace App\Http\Controllers\Service\FootballApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{
    public function index(int $matchId)
    {
        return $this->footballApiClient
            ->getMatchById(327117)
            ->request();
    }

    public function search(): JsonResponse
    {
        return response()->json($this->footballApiClient
            ->getMatches(
                request()->validate([
                    'dateFrom' => 'required|date',
                    'dateTo' => 'required|date'
                ])
            )->request());
    }
}
