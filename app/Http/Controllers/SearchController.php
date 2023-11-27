<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{

    /**
     * index
     * @param string|null $search
     * @return Response
     */
    public function index(?string $search = 'persons'): Response
    {
        return Inertia::render('Search/Search' . ucwords($search));
    }
}
