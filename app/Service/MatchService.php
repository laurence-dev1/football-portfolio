<?php

namespace App\Service;

use Exception;

class MatchService extends BaseService
{

    /**
     * getInitialList
     * Get Matches from Last 3 days
     * @return mixed
     */
    public function getInitialList(): mixed
    {
        return $this->footballApiClient->getMatches([
                'dateFrom' => (new \DateTime('-3 days'))->format('Y-m-d'),
                'dateTo'   => (new \DateTime())->format('Y-m-d'),
            ])->request();
    }

    /**
     * getMatchDetails
     * Get particular match
     * @param $matchId
     * @return mixed
     */
    public function getMatchDetails($matchId): mixed
    {
        return $this->footballApiClient
            ->getMatchById($matchId)
            ->request();
    }

    /**
     * @param $filters
     * @return mixed
     * @throws Exception
     */
    public function search($filters): mixed
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

        return $this->footballApiClient
            ->getMatches($filters->all())
            ->request();
    }
}
