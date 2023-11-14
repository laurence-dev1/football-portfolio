<?php

namespace App\Http\Controllers\Service\FootballApi;

use App\Http\Controllers\Controller;
use App\Service\Api\FootballApi\FootballApi;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{

    /**
     * @param string|null $search
     * @return Response
     */
    public function index(?string $search = 'person')
    {
        return Inertia::render('Search', [
            'type'        => $search,
            'initialList' => $this->requestInitialList($search)
        ]);
    }

    /**
     * @param string $type
     * @return mixed
     */
    private function requestInitialList(string $type): mixed
    {
        $apiClient = new FootballApi();

        if ($type === 'person') {
            // api only allows request to particular person
            return $apiClient->getPersonById(44)->request();
        }

        if ($type === 'match') {
            return $apiClient->getMatches([
                    'dateFrom' => (new \DateTime('-9 days'))->format('Y-m-d'),
                    'dateTo'   => (new \DateTime())->format('Y-m-d')
                ])->request();
        }

        if ($type === 'team') {
            return $apiClient->getTeams()->request();
        }

        return $apiClient->getCompetition()->request();
    }
}
