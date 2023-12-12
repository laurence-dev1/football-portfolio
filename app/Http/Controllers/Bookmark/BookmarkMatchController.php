<?php

namespace App\Http\Controllers\Bookmark;

use App\Http\Controllers\Controller;
use App\Service\MatchService;
use Illuminate\Http\JsonResponse;

class BookmarkMatchController extends Controller
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

    /**
     * store
     * Add match bookmark
     * @return JsonResponse
     *
     */
    public function store(): JsonResponse
    {
        return $this->formatAjaxResponse($this->matchService->addBookmark());
    }

    /**
     * destroy
     * Remove match bookmark
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        return $this->formatAjaxResponse($this->matchService->removeBookmark());
    }
}
