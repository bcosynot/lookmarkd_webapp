<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MetzWeb\Instagram\Instagram;

class DashboardController extends Controller {
	
	/**
	 * @Route("/dashboard/influencer", name="dashboard_influencer")
	 */
	public function dashboardIndexAction() {

		$model = array();
		
		$instagramClientId = $this->container->getParameter('instagram.client.id');
		$instagramClientSecret = $this->container->getParameter('instagram.client.secret');
		$user = $this->getUser();
		$instagram = new Instagram(array(
					    'apiKey'      => $instagramClientId,
					    'apiSecret'   => $instagramClientSecret,
					    'apiCallback' => $this->generateUrl('instagram_login')
					));
		$instagram->setAccessToken($user->getInstagramAccessToken());
		$instagram->setSignedHeader(true);
		$followers = $instagram->getUserFollower();
		$followerCount = 0;
		do {
			if(null!=$followers) {
				$followerCount += count($followers->data);
				$followers = $instagram->pagination($followers);
			}
		} while($followers);
		$model['followerCount'] = $followerCount;
		$mediaCount = 0;
		$totalMediaLikes = 0;
		$totalMediaComments = 0;
		$media = $instagram->getUserMedia();
		do {
			if(null!=$media) {
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
		$nextStep = $this->get('social_profile_util')->getNextOnboardingStep($user);
		$model['nextStep'] = $nextStep;
		if(null!=$nextStep && $nextStep === 'bloggername') {
			$model['saveBloggerNameURL'] = $this->get('router')->generate('edit_profile', array('fieldName'=>'bloggerName','value'=>null), true);
		}
		return $this->render ( 'controller/dashboard/dashboard.html.twig', $model );
	}
	
}
