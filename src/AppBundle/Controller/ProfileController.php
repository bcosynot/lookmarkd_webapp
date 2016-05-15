<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends Controller {
	const FIELD_NAME_REAL_NAME = 'realName';
	const FIELD_NAME_POSTING_CATEGORIES = 'postingCategories';
	
	/**
	 * @Route("/profile/", name="view_profile")
	 */
	public function viewProfileAction() {
		return $this->render ( 'controller/profile/viewProfile.html.twig' );
	}
	
	/**
	 * @Route("/profile/edit/{fieldName}/{value}", name="edit_profile", defaults={"fieldName"="na","value"=-999999})
	 * @param string $fieldName
	 * @param string|int|long $value
	 */
	public function editProfileAction(Request $request,$fieldName,$value) {
		if($fieldName!=='na') {
			if($value===-999999) {
				// Let's fetch the value from post, maybe?
				if(null!=$request->request->get('value') && sizeof($request->request->get('value')) > 0) {
					$value = $request->request->get('value');
				} else {
					return new JsonResponse ( array (
							'success' => false,
							'error' => 'No value supplied for fieldName'.$fieldName,
					) );
				}
			}
			$userService = $this->get('user_service');
			$userProfile = $userService->getUserProfile($this->getUser());
			if($fieldName==='bloggerName') {
				$userProfile->setBloggerName($value);
				$userService->saveUserProfile($userProfile);
			}
			return new JsonResponse ( array (
					'success' => true
			) );
		} else {
			return new JsonResponse ( array (
					'success' => false,
					'error' => 'No field name supplied',
			) );
		}
	}
	
	/**
	 * @Route("/profile/edit/add/postingcategory/", name="add_posting_category")
	 */
	public function addPostingCategoryAction(Request $request) {
		$model = array ();
		$model ['refrer'] = $request->headers->get ( 'referer' );
		$model ['submitURL'] = $this->get ( 'router' )->generate ( 'add_posting_category_submit', array (
				'postingCategoryId' => null 
		), true );
		return $this->render ( 'controller/profile/add_posting_category.html.twig', $model );
	}
	
	/**
	 * @Route("/profile/edit/add/postingcategory/submit/{postingCategoryId}", name="add_posting_category_submit", defaults={"postingCategoryId" = -99})
	 */
	public function addPostingCategorySubmitAction($postingCategoryId) {
		if (null != $postingCategoryId && $postingCategoryId > 0) {
			$user = $this->getUser ();
			$userService = $this->get('user_service');
			$userProfile = $userService->getUserProfile($user);
			if(null==$userProfile) {
				$userProfile = new UserProfile();
				$userProfile->setUser($user);
				$userService->saveUserProfile($userProfile);
			}
			$userService->addPostingCategory ( $user, $postingCategoryId );
			return new JsonResponse ( array (
					'success' => true 
			) );
		} else {
			return new JsonResponse ( array (
					'success' => false
			) );
		}
	}
}
