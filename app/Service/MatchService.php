<?php

namespace App\Service;

use Exception;

class MatchService extends BaseService
{

    /**
     * getInitialList
     * Get Recent Matches (by 3-Day Difference)
     * @return array
     */
    public function getInitialList(): array
    {
        return $this->processReturn(
            $this->footballApiClient->getMatches([
                'dateFrom' => (new \DateTime('-3 days'))->format('Y-m-d'),
                'dateTo'   => (new \DateTime())->format('Y-m-d'),
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
     * @param $filters
     * @return array
     * @throws Exception
     */
    public function search($filters): array
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

        return $this->processReturn(
            $this->footballApiClient
                ->getMatches($filters->all())
                ->request()
        );
    }

    /**
     * @param $response
     * @return array
     */
    private function processReturn($response): array
    {
        if (array_key_exists('errorCode', $response) === true) {
            return [
                'status' => false,
                'data'   => []
            ];
        }

        return [
            'status' => true,
            'data'   => array_reverse($response['matches'])
        ];
    }
}
