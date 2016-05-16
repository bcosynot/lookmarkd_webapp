<?php

namespace AppBundle\Core\Service;


interface CampaignServiceInterface
{
    public function saveOrUpdateCampaign($campaign);

    public function saveOrUpdateCampaignParticipant($campaignParticipant);

    public function getNewRequests($user);

    public function updateCampaignParticipantStatus($campaignParticipantId, $status);

    public function getAcceptedRequests($user);
}