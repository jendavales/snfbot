<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use Forms\ProfileEditForm;
use Models\Account;
use Models\Profile;
use Models\User;

class ProfilesController extends Controller
{
    public function saveProfile(Request $request)
    {
        $profileForm = new ProfileEditForm();
        $profileForm->loadData($request->getBody());
        if ($profileForm->validate()) {
            $profile = $this->handleForm($profileForm);
        }

        return json_encode([
            'id' => is_null($profile) ? null : $profile->id
        ]);
    }

    public function handleForm(ProfileEditForm $profileForm): ?Profile
    {
        //CREATE NEW
        if ($profileForm->id === 'undefined') {
            $formArray = $profileForm->toArray();
            $formArray['user'] = new User(['id' => $formArray['user']]);
            $profile = new Profile($formArray);
            $profile->user->id = Application::$app->user->id;
            $profile->insert();
            return $profile;
        }

        //UPDATE
        $profile = new Profile();
        $profile->fetch(['id' => $profileForm->id, 'user' => Application::$app->user->id]);
        if (is_null($profile->id)) {
            //USER HAS NO ACCESS TO THIS PROFILE
            Application::$app->response->setStatusCode(Response::FORBIDDEN);
            return null;
        }
        $profile->loadPropertiesFromArray($profileForm->toArray());
        $profile->update();

        return $profile;
    }

    public function setProfile(Request $request) {
        $data = $request->getBody();
        if (!array_key_exists('profile', $data) || !array_key_exists('account', $data)) {
            return null;
        }

        $account = new Account();
        $account->fetch(['id' => $data['account']]);
        if ($account->user->id !== Application::$app->user->id) {
            return;
        }

        if ($data['profile'] === Profile::PROFILE_NONE) {
            $account->profile = null;
        } else {
            $profile = new Profile();
            $profile->fetch(['id' => $data['profile']]);
            if ($profile->user->id !== Application::$app->user->id) {
                return;
            }
            $account->profile = $profile;
        }

        $account->update();
    }
}
