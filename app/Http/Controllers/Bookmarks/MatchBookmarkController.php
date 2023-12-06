<?php

namespace App\Http\Controllers\Bookmarks;

use App\Http\Controllers\Controller;
use App\Service\MatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatchBookmarkController extends Controller
{

    /**
     * @var MatchService $matchService
     */
    private MatchService $matchService;

    /**
     * __construct
     * @param MatchService $matchService
     */
    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    /**
     * index
     * Retrieve match bookmarks
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->formatAjaxResponse($this->matchService->getMatchBookmarks());
    }
}
