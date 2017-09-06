<?php
/**
 * Created by IntelliJ IDEA.
 * User: Vivek
 * Date: 14-05-2016
 * Time: 09:49 PM
 */

namespace AppBundle\Core\Service;

use AppBundle\Core\Dao\CampaignDAO;
use AppBundle\Entity\Campaign;
use AppBundle\Entity\CampaignParticipants;
use AppBundle\Entity\User;
use Monolog\Logger;

class CampaignService implements CampaignServiceInterface
{

    /**
     * DAO for campaign.
     *
     * @var CampaignDAO
     */
    private $campaignDAO;

    /**
     * Logging handler.
     *
     * @var Logger
     */
    private $logger;

    public function __construct(CampaignDAO $campaignDAO, Logger $logger)
    {
        $this->campaignDAO = $campaignDAO;
        $this->logger = $logger;
    }

    /**
     * @param $campaign Campaign
     * @return Campaign
     */
    public function saveOrUpdateCampaign($campaign)
    {
        return $this->campaignDAO->saveOrUpdate($campaign);
    }

    /**
     * @param $campaignParticipant CampaignParticipants
     * @return CampaignParticipants
     */
    public function saveOrUpdateCampaignParticipant($campaignParticipant)
    {
        return $this->campaignDAO->saveOrUpdateCampaignParticipant($campaignParticipant);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getNewRequests($user)
    {
        return $this->campaignDAO->getNewRequests($user);
    }

    public function updateCampaignParticipantStatus($campaignParticipantId, $status)
    {
        $this->campaignDAO->updateCampaignParticipantStatus($campaignParticipantId, $status);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getAcceptedRequests($user)
    {
        return $this->campaignDAO->getAcceptedRequests($user);
    }

    public function getCampaignParticipants($campaignParticipantId)
    {
        return $this->campaignDAO->getCampaignParticipants($campaignParticipantId);
    }

    public function getCompletedRequests($user)
    {
        return $this->campaignDAO->getCompletedRequests($user);
    }

    /**
     * @param $user
     * @return \AppBundle\Entity\Campaign[]
     */
    public function getActiveRequestsCreatedByUser($user)
    {
        return $this->campaignDAO->getActiveRequestsCreatedByUser($user);
    }

    /**
     * @param $campaignIds
     * @return CampaignParticipants[]
     */
    public function getCampaignParticipantsForCampaignIds($campaignIds)
    {
       return $this->campaignDAO->getCampaignParticipantsForCampaignIds($campaignIds);
    }

    public function getRequestsDueSoon($user)
    {
        return $this->campaignDAO->getRequestsDueSoon($user);
    }

    /**
     * @param $user
     * @return \AppBundle\Entity\Campaign[]
     */
    public function getEndedRequestsCreatedByUser($user)
    {
        return $this->campaignDAO->getEndedRequestsCreatedByUser($user);
    }
}