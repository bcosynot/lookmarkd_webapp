<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserPreferenceController extends Controller
{
    /**
     * @Route("/user/settings", name="userSettings")
     * @Template()
     */
    public function displayUserPreferencesAction()
    {
    	$userPreferences = $this->get('user_service')->getUserPreferences($this->getUser());
    	$userPreferenceTypes = $this->get('user_service')->getAllUserPreferenceTypes();
        return array(
                // ...
            );    }

    /**
     * @Route("/user/settings/save/{prefKey}/{value}")
     */
    public function setUserPreferenceAction($prefKey, $value)
    {
        return array(
                // ...
            );    }

}
