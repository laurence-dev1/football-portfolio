<?php

namespace App\Http\Controllers;

use App\Service\Api\FootballApi\FootballApi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var FootballApi $footballApiClient
     */
    protected FootballApi $footballApiClient;

    public function __construct()
    {
        $this->footballApiClient = new FootballApi();
    }
}
