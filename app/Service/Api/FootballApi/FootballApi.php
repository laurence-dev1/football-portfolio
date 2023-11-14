<?php

namespace App\Service\Api\FootballApi;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class FootballApi
{
    /**
     * API URL
     * @var string $apiUrl
     */
    private string $apiUrl;

    /**
     * API KEY
     * @var string $apiKey
     */
    private string $apiKey;

    /**
     * @var PendingRequest $httpClient
     */
    private PendingRequest $httpClient;

    /**
     * @var string $apiEndpoint
     */
    private string $apiEndpoint = '';

    /**
     * FootballApi constructor
     */
    public function __construct()
    {
        $configKey = 'app.apis.footballapi.';
        $this->apiUrl = config($configKey . 'url');
        $this->apiKey = config($configKey . 'key');

        $this->httpClient = Http::withHeader('X-Auth-Token', $this->apiKey);
    }

    /**
     * @return FootballApi
     */
    public function getCompetition(): FootballApi
    {
        $this->apiEndpoint .= '/competitions';
        return $this;
    }

    /**
     * @param int $personId
     * @return FootballApi
     */
    public function getPersonById(int $personId): FootballApi
    {
        $this->apiEndpoint .= '/persons/' . $personId;
        return $this;
    }

    /**
     * @param $matchId
     * @return FootballApi
     */
    public function getMatchById($matchId): FootballApi
    {
        $this->apiEndpoint .= '/matches/' . $matchId;
        return $this;
    }

    /**
     * @param array $matchFilter
     * @return FootballApi
     */
    public function getMatches(array $matchFilter = []): FootballApi
    {
        $this->apiEndpoint .= '/matches';
        if (empty($matchFilter) === false) {
            $this->apiEndpoint .= '?' . http_build_query($matchFilter);
        }

        var_dump($this->apiEndpoint);

        return $this;
    }

    public function getTeams(): FootballApi
    {
        $this->apiEndpoint .= '/teams';

        return $this;
    }

    /**
     * request
     * Return the response of request
     * @param bool $returnArr
     * @return mixed
     */
    public function request(bool $returnArr = true): mixed
    {
        $response = $this->httpClient->get($this->apiUrl . $this->apiEndpoint);

        return $returnArr === true
            ? $response->json()
            : $response->body();
    }
}
