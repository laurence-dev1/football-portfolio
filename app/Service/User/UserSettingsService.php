<?php

namespace App\Service\User;

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
            $currentUser = Auth::user();
            if ($currentUser->isThirdPartyUser() === true) {
                unset($userInfo['name'], $userInfo['email']);
            }

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
            $currentUser = Auth::user();

            if ($currentUser->isThirdPartyUser() === true) {
                throw new Exception('If you signed-in via 3rd Party Provider (e.g. Google, Facebook), adding passwords is not available.', 403);
            }

            $currentUser->update(['password' => $newPassword['new']]);
            session()->regenerate();

        } catch (Exception $exception) {
            $message = $exception->getCode() === 403
                ? $exception->getMessage()
                : 'There was an error in updating your password, kindly refresh the page and try again.';

            return $this->failedReturn($message);
        }

        return ['status' => true];
    }
}
