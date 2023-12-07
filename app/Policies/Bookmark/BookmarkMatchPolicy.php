<?php

namespace App\Policies\Bookmark;

use App\Models\Bookmark\BookmarkMatch;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookmarkMatchPolicy
{

    /**
     * addMatchBookmark
     * Check if the user already bookmarked the match to be added
     * @param User $user
     * @return Response
     */
    public function addMatchBookmark(User $user): Response
    {
        $isNotYetBookmarked = BookmarkMatch::where([
            'user_id'      => $user->id,
            'api_match_id' => request()->matchId,
        ])->get()->isEmpty();

        return $isNotYetBookmarked === true
            ? Response::allow()
            : Response::deny('You already have a bookmark of the match.');
    }

    /**
     * removeMatchBookmark
     * Check if the user has bookmarked the match to be removed
     * @param User $user
     * @return Response
     */
    public function removeMatchBookmark(User $user): Response
    {
        $isBookmarked = BookmarkMatch::where([
            'user_id'      => $user->id,
            'api_match_id' => request()->matchId,
        ])->get()->isNotEmpty() ;

        return $isBookmarked === true
            ? Response::allow()
            : Response::deny('You do not have a bookmark of the match.');
    }
}
