<?php

namespace AppBundle\Controller;

use AppBundle\Util\CampaignUtil;
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
		if($this->isInfluencer($user)) {
			return $this->redirectToRoute('dashboard_influencer');
		} else if($this->isBrand($user)) {
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
		$model = $this->redirectToOnboardingStep($user, $model);
		if($this->isBrand($user)) {
			$model = $this->updateModelForBrand($user, $model);
		} else if ($this->isInfluencer($user)) {
			$model = $this->updateModelForInfluencer($user, $model);
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

	/**
	 * @param $user
	 * @param $model
	 * @return mixed
	 */
	public function redirectToOnboardingStep($user, $model)
	{
		$nextStep = $this->get('social_profile_util')->getNextOnboardingStep($user);
		$model['nextStep'] = $nextStep;
		if (null != $nextStep && $nextStep === 'bloggername') {
			$model['saveBloggerNameURL'] = $this->get('router')->generate('edit_profile', array('fieldName' => 'bloggerName', 'value' => null), true);
			return $model;
		}
		return $model;
	}

	/**
	 * @param $user
	 * @param $model
	 * @return mixed
	 */
	public function updateModelForBrand($user, $model)
	{
		$activeCampaigns = $this->get('campaign_service')->getActiveRequestsCreatedByUser($user);
		$activeCampaignsCount = 0;
		if (null != $activeCampaigns) {
			$activeCampaignsCount = sizeof($activeCampaigns);
			$campaignService = $this->get('campaign_service');
			list($activePending, $activeAccepted, $activeCompleted, $activeDeclined) =
				CampaignUtil::getCampaignStatuses($activeCampaigns, $campaignService);
			$model['activePending'] = $activePending;
			$model['activeAccepted'] = $activeAccepted;
			$model['activeCompleted'] = $activeCompleted;
			$model['activeDeclined'] = $activeDeclined;
		}
		$model['activeCampaigns'] = $activeCampaignsCount;
		$endedCampaigns = $this->get('campaign_service')->getEndedRequestsCreatedByUser($user);
		$endedCampaignsCount = 0;
		if (null != $endedCampaigns) {
			$endedCampaignsCount = sizeof($endedCampaigns);
			$campaignService = $this->get('campaign_service');
			list($endedPending, $endedAccepted, $endedCompleted, $endedDeclined) =
				CampaignUtil::getCampaignStatuses($endedCampaigns, $campaignService);
			$model['endedPending'] = $endedPending;
			$model['endedAccepted'] = $endedAccepted;
			$model['endedCompleted'] = $endedCompleted;
			$model['endedDeclined'] = $endedDeclined;
		}
		$model['endedCampaigns'] = $endedCampaignsCount;
		return $model;
	}

	private function updateModelForInfluencer($user, $model)
	{
		$latestRequests = $this->get('campaign_service')->getNewRequests($user);
		$model['newRequests'] = $latestRequests;
		$dueSoonRequests = $this->get('campaign_service')->getRequestsDueSoon($user);
		$model['dueSoonRequests'] = $dueSoonRequests;
		$acceptedRequests = $this->get('campaign_service')->getAcceptedRequests($user);
		$model['acceptedRequests'] = $acceptedRequests;
		$completedRequests = $this->get('campaign_service')->getCompletedRequests($user);
		$model['completedRequests'] = $completedRequests;
		return $model;
	}

	/**
	 * @param $user
	 * @return bool
	 */
	public function isInfluencer($user)
	{
		return null != $user && User::USER_TYPE_INFLUENCER === $user->getUserType();
	}

	/**
	 * @param $user
	 * @return bool
	 */
	public function isBrand($user)
	{
		return null != $user && User::USER_TYPE_BRAND === $user->getUserType();
	}

}
