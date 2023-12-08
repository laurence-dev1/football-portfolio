<?php

namespace App\Service;

use App\Models\Bookmark\BookmarkMatch;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MatchService extends BaseService
{

    /**
     * getInitialList
     * Get Recent Matches (by 3-Day Difference)
     * @return array
     */
    public function getInitialList(): array
    {
        return $this->formatApiResponse(
            $this->footballApiClient->getMatches([
                'dateFrom' => (new DateTime('-3 days'))->format('Y-m-d'),
                'dateTo'   => (new DateTime())->format('Y-m-d'),
            ])->request()
        );
    }

    /**
     * getMatchDetails
     * Get particular match
     * @param string $matchId
     * @return mixed
     */
    public function getMatchDetails(string $matchId): mixed
    {
        return $this->footballApiClient
            ->getMatchById($matchId)
            ->request();
    }

    /**
     * search
     * Perform match search on API
     * @param $filters
     * @return array
     * @throws Exception
     */
    public function search($filters): array
    {
        // 7-day differences are added by default if dates are null
        if ($filters['dateFrom'] === null && $filters['dateTo'] === null) {
            $filters['dateFrom'] = (new DateTime('-6 days'))->format('Y-m-d');
            $filters['dateTo'] = (new DateTime())->format('Y-m-d');

        } else if ($filters['dateFrom'] === null && $filters['dateTo'] !== null) {
            $filters['dateFrom'] = (new DateTime($filters['dateTo'] . ' -6 days'))->format('Y-m-d');

        } else if ($filters['dateFrom'] !== null && $filters['dateTo'] === null) {
            $filters['dateTo'] = (new DateTime($filters['dateFrom'] . ' +6 days'))->format('Y-m-d');
        }

        return $this->formatApiResponse(
            $this->footballApiClient
                ->getMatches($filters->all())
                ->request()
        );
    }

    /**
     * getMatchBookmarks
     * Retrieve match bookmarks from DB and request on API
     * @return array
     */
    public function getMatchBookmarks(): array
    {
        $savedMatchesId = Auth::user()->savedMatches->implode('api_match_id', ',');
        $apiResponse = empty($savedMatchesId) === false
            ? $this->footballApiClient
                ->getMatches(['ids' => $savedMatchesId])
                ->request()

            : ['matches' => []];


        return $this->formatApiResponse($apiResponse);
    }

    /**
     * addBookmark
     * Save bookmark
     * @return array
     */
    public function addBookmark(): array
    {
        $doAuthorize = Gate::inspect('addMatchBookmark', BookmarkMatch::class);
        if ($doAuthorize->allowed() === false) {
            return $this->failedReturn($doAuthorize->message());
        }

        try {
            Auth::user()->savedMatches()->create(['api_match_id' => request()->matchId]);

        } catch (Exception $exception) {
            return $this->failedReturn('There was an error in registering your bookmark, kindly refresh the page and try again.');

        }

        return ['status' => true];
    }

    public function removeBookmark()
    {
        $doAuthorize = Gate::inspect('removeMatchBookmark', BookmarkMatch::class);
        if ($doAuthorize->allowed() === false) {
            return $this->failedReturn($doAuthorize->message());
        }

        try {
            Auth::user()->savedMatches()->where('api_match_id', request()->matchId)->delete();

        } catch (Exception $exception) {
            return $this->failedReturn('There was an error in removing your bookmark, kindly refresh the page and try again.');

        }

        return ['status' => true];
    }
}
