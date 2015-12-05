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
		$followers = $instagram->getUserFollower();
		$followerCount = count($followers->data);
		$model['followerCount'] = $followerCount;
		$mediaCount = 0;
		$totalMediaLikes = 0;
		$totalMediaComments = 0;
		do {
			$media = $instagram->getUserMedia();
			$mediaCount += count($media->data);
			foreach ($media->data as $post) {
				$totalMediaLikes += $post->likes->count;
				$totalMediaComments += $post->comments->count;
			}
		} while($media = $instagram->pagination($media));
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
