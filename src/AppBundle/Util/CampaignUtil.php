<?php
/**
 * Created by IntelliJ IDEA.
 * User: Vivek
 * Date: 27-05-2016
 * Time: 10:51 AM
 */

namespace AppBundle\Util;


use AppBundle\Core\Service\CampaignService;
use AppBundle\Entity\Campaign;
use AppBundle\Entity\CampaignParticipants;

class CampaignUtil
{

    /**
     * @param Campaign[] $campaigns
     * @param CampaignService $campaignService
     * @return array
     */
    public static function getCampaignStatuses($campaigns, CampaignService $campaignService)
    {
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
        $campaignParticipants = $campaignService->getCampaignParticipantsForCampaignIds($campaignIds);
        foreach ($campaignParticipants as $participant) {
            $campaignId = $participant->getCampaign()->getId();
            $status = $participant->getStatus();
            if ($status == CampaignParticipants::STATUS_REQUESTED) {
                $pending[$campaignId][] = $participant;
            } else if ($status == CampaignParticipants::STATUS_ACCEPTED) {
                $accepted[$campaignId][] = $participant;
            } else if ($status == CampaignParticipants::STATUS_COMPLETED) {
                $completed[$campaignId][] = $participant;
            } else if ($status == CampaignParticipants::STATUS_DECLINED) {
                $declined[$campaignId][] = $participant;
            } else if ($status == CampaignParticipants::STATUS_IGNORED) {
                $pending[$campaignId][] = $participant;
            }
        }
        return array($pending, $accepted, $completed, $declined);
    }
}