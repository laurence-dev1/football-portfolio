<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserInfoSettingRequest;
use App\Http\Requests\User\UserPasswordSettingRequest;
use App\Service\User\UserSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserSettingsController extends Controller
{

    /**
     * @var UserSettingsService $userSettingsService
     */
    private UserSettingsService $userSettingsService;

    /**
     * __construct
     * @param UserSettingsService $userSettingsService
     */
    public function __construct(UserSettingsService $userSettingsService)
    {
        $this->userSettingsService = $userSettingsService;
    }

    /**
     * index
     * Render Settings Page
     * @return Response
     */
    public function index(): Response
    {
        $currentAuthUser = Auth::user();

        return Inertia::render('User/Settings', [
            'currentUser'      => $currentAuthUser->only(['name', 'username', 'email']),
            'isThirdPartyUser' => $currentAuthUser->isThirdPartyUser()
        ]);
    }

    /**
     * updateInfo
     * Update user info (name, email, username)
     * @param UserInfoSettingRequest $userInfo
     * @return JsonResponse
     */
    public function updateInfo(UserInfoSettingRequest $userInfo): JsonResponse
    {
        return $this->formatAjaxResponse($this->userSettingsService->updateInfo($userInfo->all()));
    }

    /**
     * updatePassword
     * @param UserPasswordSettingRequest $userPassword
     * @return JsonResponse
     */
    public function updatePassword(UserPasswordSettingRequest $userPassword): JsonResponse
    {
        return $this->formatAjaxResponse($this->userSettingsService->updatePassword($userPassword->only('new')));
    }
}
