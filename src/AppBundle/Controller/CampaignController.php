<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $followers = array();
        if (null != $influencers && sizeof($influencers) > 0) {
            $socialProfileUtil = $this->get('social_profile_util');
            $socialService = $this->get('social_service');
            foreach ($influencers as $influencer) {
                $socialProfileUtil->updateSocialStatisticsIfNecessary($influencer);
                $instagramProfilePicture = '';
                $socialProfile = $userService->getSocialProfile($influencer);
                if (null != $socialProfile
                    && null != $socialProfile->getProfilePicture()
                ) {
                    $instagramProfilePicture = $socialProfile->getProfilePicture();
                }
                $instagramProfilePictures[] = $instagramProfilePicture;
                $socialStatistics = $socialService->getMostRecentFollowerCount($influencer);
                if(null!=$socialStatistics && sizeof($socialStatistics)>0) {
                    $followers[] = $socialStatistics[0]->getStatistic();
                } else {
                    $followers[] = -1;
                }
            }
        }
        return $this->render('controller/campaign/create.html.twig', array(
            'influencers' => $influencers,
            'profilePictures' => $instagramProfilePictures,
            'followers'=>$followers));
    }
}
