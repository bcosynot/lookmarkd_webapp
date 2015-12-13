<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\UserPreference;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserPreferenceController extends Controller {
	/**
	 * @Route("/user/settings", name="user_settings")
	 */
	public function displayUserPreferencesAction() {
		$userService = $this->get ( 'user_service' );
		$userPreferenceTypes = $userService->getAllUserPreferenceTypes ();
		$userPreferences = array ();
		$user = $this->getUser ();
		if (null != $userPreferenceTypes && sizeof ( $userPreferenceTypes ) > 0) {
			foreach ( $userPreferenceTypes as $type ) {
				$userPreference = $userService->getUserPreference ( $user, $type->getPreferenceKey () );
				if(null == $userPreference) {
					$userPreference = new UserPreference();
					$userPreference->setUser($user);
					$userPreference->setPreferenceType($type);
					$userPreference->setValue(1);
				}
				$userPreferences[]=$userPreference;
			}
		}
		return $this->render ( 'controller/userpreferences/settings.html.twig', array (
				'userPreferences' => $userPreferences,
		) );
	}
	
	/**
	 * @Route("/user/settings/save/{prefKey}/{value}", name="set_user_pref")
	 */
	public function setUserPreferenceAction($prefKey, $value) {
		$userService = $this->get ( 'user_service' );
		$user = $this->getUser ();
		$userPreference = $userService->getUserPreference ( $user, $prefKey );
		if(null == $userPreference) {
			$userPreference = new UserPreference();
			$userPreference->setUser($user);
			$type = $userService->getUserPreferenceType($prefKey);
			$userPreference->setPreferenceType($type);
		}
		$userPreference->setValue($value);
		$userService->setUserPreference($userPreference);
		return new JsonResponse ( array (
				'success' => true 
		) );	
	}
}
