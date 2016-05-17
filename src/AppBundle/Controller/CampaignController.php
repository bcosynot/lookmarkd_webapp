<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Campaign;
use AppBundle\Entity\CampaignParticipants;
use Doctrine\DBAL\Types\JsonArrayType;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
     * @return JsonResponse
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
                $selectedInfluencerUser = $this->get('user_service')->getUserFromId($selectedInfluencer);
                $campaignParticipant = new CampaignParticipants();
                $campaignParticipant->setCampaign($campaign);
                $campaignParticipant->setParticipant($selectedInfluencerUser);
                $campaignParticipant->setStatus(CampaignParticipants::STATUS_REQUESTED);
                $this->get('campaign_service')->saveOrUpdateCampaignParticipant($campaignParticipant);
            }
        }

        return new JsonResponse($campaign->getId());

    }

    /**
     * @Route("/influencer/campaign/requests/{_format}",
     *     name="new_campaign_requests",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_format": "html|json",
     *         "_method": "GET"
     *     })
     * @param Request $request
     * @return JsonResponse
     */
    public function newCollaborationRequestsAction(Request $request)
    {
        $user = $this->getUser();
        $latestRequests = $this->get('campaign_service')->getNewRequests($user);
        if ($request->getRequestFormat() == 'json') {
            return new JsonResponse(array('requestsCount' => sizeof($latestRequests)));
        } else {
            return $this->render('controller/campaign/requests.html.twig', array(
                'requests' => $latestRequests,
                'acceptedStatus' => CampaignParticipants::STATUS_ACCEPTED,
                'declinedStatus' => CampaignParticipants::STATUS_DECLINED,
                'ignoredStatus' => CampaignParticipants::STATUS_IGNORED,
            ));
        }
    }


    /**
     * @Route("/influencer/campaign/requests/update/status", name="influencer_campaign_request_update_status")
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCampaignParticipantStatus(Request $request)
    {

        $campaignParticipantId = $request->get('campaignParticipantId');
        $status = $request->get('status');

        $this->get('campaign_service')->updateCampaignParticipantStatus($campaignParticipantId, $status);

        return new JsonResponse(array('campaignParticipantId' => $campaignParticipantId));
    }

    /**
     * @Route("/influencer/campaign/accepted", name="accepted_campaign_requests")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function acceptedCollaborationRequestsAction()
    {
        $user = $this->getUser();
        $acceptedRequests = $this->get('campaign_service')->getAcceptedRequests($user);
        return $this->render('controller/campaign/accepted.html.twig', array(
            'requests' => $acceptedRequests,
            'completedStatus' => CampaignParticipants::STATUS_COMPLETED,
        ));
    }

    /**
     * @Route("/influencer/campaign/due", name="due_campaign_requests")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dueSoonCollaborationRequestsAction()
    {
        $user = $this->getUser();
        $acceptedRequests = $this->get('campaign_service')->getRequestsDueSoon($user);
        return $this->render('controller/campaign/duesoon.html.twig', array(
            'requests' => $acceptedRequests,
            'completedStatus' => CampaignParticipants::STATUS_COMPLETED,
        ));
    }

    /**
     * @Route("/influencer/campaign/attach/link", name="attach_link")
     * @param Request $request
     * @return JsonResponse
     */
    public function attachLinkAction(Request $request) {

        $campaignParticipantId = $request->get('campaignParticipantId');;
        $link = $request->get('link');

        $campaignParticipants = $this->get('campaign_service')->getCampaignParticipants($campaignParticipantId);
        $links = $campaignParticipants->getURLs();
        $links[] = $link;
        $campaignParticipants->setURLs($links);
        $this->get('campaign_service')->saveOrUpdateCampaignParticipant($campaignParticipants);
        
        return new JsonResponse();
    }

    /**
     * @Route("/influencer/campaign/completed", name="completed_campaign_requests")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function completedCollaborationRequestsAction()
    {
        $user = $this->getUser();
        $acceptedRequests = $this->get('campaign_service')->getCompletedRequests($user);
        return $this->render('controller/campaign/completed.html.twig', array(
            'requests' => $acceptedRequests,
            'completedStatus' => CampaignParticipants::STATUS_COMPLETED,
        ));
    }

    /**
     * @Route("/brand/campaigns/active", name="active_campaigns")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activeCollaborationRequestsAction()
    {
        $user = $this->getUser();
        $campaigns = $this->get('campaign_service')->getActiveRequestsCreatedByUser($user);
        $campaignIds = array();
        $pending = array();
        $accepted = array();
        $completed = array();
        $declined = array();
        foreach ($campaigns as $campaign) {
            $campaignId = $campaign->getId();
            $campaignIds[] = $campaignId;
            $pending[$campaignId] = array();
            $accepted[$campaignId] = array();
            $completed[$campaignId] = array();
            $declined[$campaignId] = array();
        }
        $campaignParticipants = $this->get('campaign_service')->getCampaignParticipantsForCampaignIds($campaignIds);
        foreach ($campaignParticipants as $participant) {
            $campaignId = $participant->getCampaign()->getId();
            $status = $participant->getStatus();
            if ($status == CampaignParticipants::STATUS_REQUESTED) {
                $pending[$campaignId][] = $participant;
            } else if ($status == CampaignParticipants::STATUS_ACCEPTED) {
                $accepted[$campaignId][] = $participant;
            } else if ($status == CampaignParticipants::STATUS_COMPLETED) {
                $completed[$campaignId][] = $participant;
            } else if($status == CampaignParticipants::STATUS_DECLINED) {
                $declined[$campaignId][] = $participant;
            } else if($status == CampaignParticipants::STATUS_IGNORED) {
                $pending[$campaignId][] = $participant;
            }
        }

        return $this->render('controller/campaign/active.html.twig', array(
            'campaigns' => $campaigns,
            'pending' => $pending,
            'accepted' => $accepted,
            'completed' => $completed,
            'declined' => $declined,
        ));
    }

}
