<?php

namespace App\Service;

use App\Service\Api\FootballApi\FootballApi;

class BaseService
{
    protected FootballApi $footballApiClient;

    public function __construct()
    {
        $this->footballApiClient = new FootballApi();
    }

    /**
     * formatApiResponse
     * Format response from API
     * @param array $response
     * @return array
     */
    protected function formatApiResponse(array $response): array
    {
        if (array_key_exists('errorCode', $response) === true) {
            return $this->failedReturn();
        }

        return [
            'status' => true,
            'data'   => array_reverse($response['matches'])
        ];
    }

    /**
     * failedReturn
     * Return error
     * @param string $message
     * @return array
     */
    protected function failedReturn(string $message = ''): array
    {
        return [
            'status' => false,
            'data'   => empty($message) === false ? ['message' => $message] : []
        ];
    }
}
