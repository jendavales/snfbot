<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use core\Response;
use Forms\ProfileEditForm;
use Models\Profile;

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
            $profile = new Profile($profileForm->toArray());
            $profile->user = Application::$app->user->id;
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
}
