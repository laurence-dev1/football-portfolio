<?php

namespace App\Http\Controllers;

use App\Service\Api\FootballApi\FootballApi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * formatAjaxResponse
     * Format to proper json response
     * @param array $data
     * @return JsonResponse
     */
    protected function formatAjaxResponse(array $data): JsonResponse
    {
        return response()->json($data, $data['status'] === true ? 200 : 400);
    }
}
