<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MetzWeb\Instagram\Instagram;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class CampaignController extends Controller
{

    /**
     * @Route("/brand/campaign/create", name="campaign_create")
     */
    function campaignCreateAction()
    {
        $userService = $this->get('user_service');
        $influencers = $userService->getAllInfluencers();
        $instagramProfilePictures = array();
        if (null != $influencers && sizeof($influencers) > 0) {
            foreach ($influencers as $influencer) {
                $instagramProfilePicture = '';
                $socialProfile = $userService->getSocialProfile($influencer);
                if (null != $socialProfile
                    && null != $socialProfile->getProfilePicture()
                ) {
                    $instagramProfilePicture = $socialProfile->getProfilePicture();
                }
                $instagramProfilePictures[] = $instagramProfilePicture;
            }
        }
        return $this->render('controller/campaign/create.html.twig', array(
            'influencers' => $influencers,
            'profilePictures' => $instagramProfilePictures));
    }
}
