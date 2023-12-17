<?php

namespace App\Service\User;

use App\Models\User;
use App\Service\BaseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserSettingsService extends BaseService
{

    /**
     * updateInfo
     * @param array $userInfo
     * @return true[]
     */
    public function updateInfo(array $userInfo): array
    {
        try {
            Auth::user()->update($userInfo);
            session()->regenerate();

        } catch (Exception $exception) {
            return $this->failedReturn('There was an error in updating your information, kindly refresh the page and try again.');
        }

        return ['status' => true];
    }

    /**
     * updatePassword
     * @param array $newPassword
     * @return array|true[]
     */
    public function updatePassword(array $newPassword): array
    {
        try {
            Auth::user()->update(['password' => $newPassword['new']]);
            session()->regenerate();

        } catch (Exception $exception) {
            return $this->failedReturn('There was an error in updating your password, kindly refresh the page and try again.');
        }

        return ['status' => true];
    }
}
