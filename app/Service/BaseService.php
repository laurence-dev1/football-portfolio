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
}
