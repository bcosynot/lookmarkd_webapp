<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MetzWeb\Instagram\Instagram;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends Controller {
	
	/**
	 * @Route("/dashboard", name="dashboard")
	 */
	public function dashboardIndecAction() {
		$user = $this->getUser();
		if(null!=$user && User::USER_TYPE_INFLUENCER === $user->getUserType()) {
			return $this->redirectToRoute('dashboard_influencer');
		} else if(null!=$user && User::USER_TYPE_BRAND === $user->getUserType()) {
			//TODO: Add dashboard for brand
			return $this->redirectToRoute('dashboard_influencer');
		} else {
			return $this->redirectToRoute('missing_user_type');
		}
	}
	
	/**
	 * @Route("/dashboard/influencer", name="dashboard_influencer")
	 */
	public function dashboardInfluencerAction() {

		$model = array();
		$user = $this->getUser();
		$nextStep = $this->get('social_profile_util')->getNextOnboardingStep($user);
		$model['nextStep'] = $nextStep;
		if(null!=$nextStep && $nextStep === 'bloggername') {
			$model['saveBloggerNameURL'] = $this->get('router')->generate('edit_profile', array('fieldName'=>'bloggerName','value'=>null), true);
		}
		return $this->render ( 'controller/dashboard/dashboard.html.twig', $model );
	}

	/**
	 * @Route("/instagram/statistics/followers/count", name="insta_stats_followers_count")
	 */
	public function getInstaFollowersCountAction() {
		$model = array();

		$socialStatistic = $this->get('social_service')->getMostRecentFollowerCount($this->getUser());
		if(null!=$socialStatistic && sizeof($socialStatistic) > 0) {
			$model['followerCount'] = $socialStatistic[0]->getStatistic();
		} else {
			$model['followerCount'] = -1;
		}
		
		return new JsonResponse($model);
	}
	
	/**
	 * @Route("/instagram/statistics/media/count", name="insta_stats_media_counts")
	 */
	public function getInstaMediaCountsAction() {
		$model = array();

		$socialService = $this->get('social_service');
		$user = $this->getUser();
		$mediaCount = $socialService->getMostRecentMediaCount($user);
		if(null!=$mediaCount && sizeof($mediaCount) > 0) {
			$model['mediaCount'] = $mediaCount[0]->getStatistic();
		} else {
			$model['mediaCount'] = -1;
		}
		$mediaLikesCount  = $socialService->getMostRecentMediaLikesCount($user);
		if(null!=$mediaLikesCount && sizeof($mediaLikesCount) > 0) {
			$model['likesCount'] = $mediaLikesCount[0]->getStatistic();
		} else {
			$model['likesCount'] = -1;
		}
		$mediaCommentsCount  = $socialService->getMostRecentMediaCommentsCount($user);
		if(null!=$mediaCommentsCount && sizeof($mediaCommentsCount) > 0) {
			$model['commentsCount'] = $mediaCommentsCount[0]->getStatistic();
		} else {
			$model['commentsCount'] = -1;
		}
		
		return new JsonResponse($model);
	}
	
}
