<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MetzWeb\Instagram\Instagram;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends Controller {
	
	/**
	 * @Route("/dashboard/influencer", name="dashboard_influencer")
	 */
	public function dashboardIndexAction() {

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
	 * @param User user
	 * @param Instagram instagram
	 */private function updateUserAccessToken(Instagram $instagram, User $user) {
		$instagram->setAccessToken($user->getInstagramAccessToken());
		$instagram->setSignedHeader(true);
	}

	
	/**
	 * Get instagram client for fetching stuff from instagram
	 *@return Instagram 
	 */
	 private function getInstagramClient() {
		$instagramClientId = $this->container->getParameter('instagram.client.id');
		$instagramClientSecret = $this->container->getParameter('instagram.client.secret');
		$instagram = new Instagram(array(
					    'apiKey'      => $instagramClientId,
					    'apiSecret'   => $instagramClientSecret,
					    'apiCallback' => $this->generateUrl('instagram_login')
					));
		return $instagram;
	}

	
	/**
	 * @Route("/instagram/statistics/followers/count", name="insta_stats_followers_count")
	 */
	public function getInstaFollowersCountAction() {
		$model = array();
		
		$instagram = $this->getInstagramClient ();
		$user = $this->getUser();
		$this->updateUserAccessToken ( $instagram, $user );
		
		$followers = $instagram->getUserFollower();
		$followerCount = 0;
		do {
			if(null!=$followers && null!=$followers->data) {
				$followerCount += count($followers->data);
				$followers = $instagram->pagination($followers);
			}
		} while($followers);
		$model['followerCount'] = $followerCount;
		
		return new JsonResponse($model);
	}
	
	/**
	 * @Route("/instagram/statistics/media/count", name="insta_stats_media_counts")
	 */
	public function getInstaMediaCountsAction() {
		$model = array();
		
		$instagram = $this->getInstagramClient ();
		$user = $this->getUser();
		$this->updateUserAccessToken ( $instagram, $user );
	
		$mediaCount = 0;
		$totalMediaLikes = 0;
		$totalMediaComments = 0;
		$media = $instagram->getUserMedia();
		do {
			if(null!=$media && null!=$media->data) {
				$mediaCount += count($media->data);
				//dump($media);
				foreach ($media->data as $post) {
					$totalMediaLikes += $post->likes->count;
					$totalMediaComments += $post->comments->count;
				}
			}
			$media = $instagram->pagination($media);
		} while($media);
		$model['mediaCount'] = $mediaCount;
		$model['likesCount'] = $totalMediaLikes;
		$model['commentsCount'] = $totalMediaComments;
		
		return new JsonResponse($model);
	}
	
}
