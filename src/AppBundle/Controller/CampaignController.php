<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Campaign;
use AppBundle\Entity\CampaignParticipants;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CampaignController extends Controller
{

    function getFollowerCounts($influencers)
    {

        $followers = array();
        if (null != $influencers && sizeof($influencers) > 0) {
            $socialProfileUtil = $this->get('social_profile_util');
            $socialService = $this->get('social_service');
            foreach ($influencers as $influencer) {
                $socialProfileUtil->updateSocialStatisticsIfNecessary($influencer);
                $socialStatistics = $socialService->getMostRecentFollowerCount($influencer);
                if (null != $socialStatistics && sizeof($socialStatistics) > 0) {
                    $followers[] = $socialStatistics[0]->getStatistic();
                } else {
                    $followers[] = -1;
                }
            }
        }

        return $followers;
    }

    function getInstagramProfilePictures($influencers)
    {

        $userService = $this->get('user_service');
        $instagramProfilePictures = array();
        if (null != $influencers && sizeof($influencers) > 0) {
            foreach ($influencers as $influencer) {
                $instagramProfilePicture = 'na';
                $socialProfile = $userService->getSocialProfile($influencer);
                if (null != $socialProfile
                    && null != $socialProfile->getProfilePicture()
                ) {
                    $instagramProfilePicture = $socialProfile->getProfilePicture();
                }
                $instagramProfilePictures[] = $instagramProfilePicture;
            }
        }

        return $instagramProfilePictures;
    }

    /**
     * @Route("/brand/campaign/create", name="campaign_create")
     */
    function campaignCreateAction()
    {
        $userService = $this->get('user_service');
        $influencers = $userService->getAllInfluencers();
        $followers = $this->getFollowerCounts($influencers);
        $instagramProfilePictures = $this->getInstagramProfilePictures($influencers);

        return $this->render('controller/campaign/create.html.twig', array(
            'influencers' => $influencers,
            'profilePictures' => $instagramProfilePictures,
            'followers' => $followers));
    }

    /**
     * @Route("/brand/campaign/create/fetch/influencers/", name="campaign_create_fetch_influencers")
     * @param Request $request
     * @return JsonResponse
     */
    function campaignCreateFetchInfluencersAction(Request $request)
    {
        $categoryId = $request->get('categoryId');
        $followerCount = $request->get('followerCount');

        $categoryIds = array();
        if ($categoryId == '-999') {
            for ($i = 1; $i <= 9; $i++) {
                $categoryIds[] = $i;
            }
        } else {
            $categoryIds[] = $categoryId;
        }

        $userService = $this->get('user_service');
        $influencers = $userService->getInfluencers($categoryIds, $followerCount);
        $followers = $this->getFollowerCounts($influencers);
        $instagramProfilePictures = $this->getInstagramProfilePictures($influencers);

        $data = array();
        foreach ($influencers as $index => $influencer) {
            $data[] = array(
                'username' => $influencer->getUsername(),
                'followerCount' => $followers[$index],
                'profilePicture' => $instagramProfilePictures[$index],
                'userId' => $influencer->getId()
            );
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/brand/campaign/create/save/", name="campaign_create_save")
     * @param Request $request
     */
    function saveCampaignAction(Request $request)
    {

        $campaignName = $request->get('campaignName');
        $startDate = date_create_from_format('Y-m-d', $request->get('startDate'));
        $endDate = date_create_from_format('Y-m-d', $request->get('endDate'));
        $brief = $request->get('brief');
        $numPosts = $request->get('numPosts');
        $handles = $request->get('handles');
        $hashtags = $request->get('hashtags');
        $cashReward = $request->get('cashReward');
        $kindReward = $request->get('kindReward');
        $selectedInfluencers = $request->get('selectedInfluencers');
        $msgSubject = $request->get('msgSubject');
        $msgBody = $request->get('msgBody');

        $campaign = new Campaign();
        $campaign->setCampaignName($campaignName);
        $campaign->setStart($startDate);
        $campaign->setEnd($endDate);
        $campaign->setOwner($this->getUser());
        $campaign->setBrief($brief);
        $campaign->setNumPosts($numPosts);
        $campaign->setHandles($handles);
        $campaign->setCashReward($cashReward);
        $campaign->setKindReward($kindReward);
        $campaign->setHashtags($hashtags);
        $campaign->setMsgBody($msgBody);
        $campaign->setMsgSubject($msgSubject);

        $campaign = $this->get('campaign_service')->saveOrUpdateCampaign($campaign);

        if (null != $selectedInfluencers && sizeof($selectedInfluencers) > 0) {
            foreach ($selectedInfluencers as $selectedInfluencer) {
                $selectedInfluencer = intval($selectedInfluencer);
                dump($selectedInfluencer);
                $selectedInfluencerUser = $this->get('user_service')->getUserFromId($selectedInfluencer);
                dump($selectedInfluencerUser);
                $campaignParticipant = new CampaignParticipants();
                $campaignParticipant->setCampaign($campaign);
                $campaignParticipant->setParticipant($selectedInfluencerUser);
                $campaignParticipant->setStatus(CampaignParticipants::STATUS_REQUESTED);
                dump($campaignParticipant);
                $this->get('campaign_service')->saveOrUpdateCampaignParticipant($campaignParticipant);
            }
        }

        return new JsonResponse($campaign->getId());

    }
}
