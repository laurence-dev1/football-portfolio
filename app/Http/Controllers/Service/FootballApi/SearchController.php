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
    public function index(?string $search = 'persons')
    {
        return Inertia::render('Search/Search' . ucwords($search), [
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

        if ($type === 'persons') {
            // api only allows request to particular person
            return $apiClient->getPersonById(44)->request();
        }

        if ($type === 'matches') {
            $response = $apiClient->getMatches([
                    'dateFrom' => (new \DateTime('-3 days'))->format('Y-m-d'),
                    'dateTo'   => (new \DateTime())->format('Y-m-d'),
                ])->request();

            return $this->cutData($response, 'matches');
        }

        if ($type === 'teams') {
            return $apiClient->getTeams()->request();
        }

        return $apiClient->getCompetition()->request();
    }

    private function cutData($data, $key)
    {
        return array_slice($data[$key], 0, 3);
    }
}
