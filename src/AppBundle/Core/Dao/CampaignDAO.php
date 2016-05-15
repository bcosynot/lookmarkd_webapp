<?php

namespace AppBundle\Core\Dao;


use AppBundle\Entity\Campaign;
use AppBundle\Entity\CampaignParticipants;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

class CampaignDAO
{
    /**
     *
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @var Logger
     */
    private $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @param $campaign Campaign
     * @return Campaign
     */
    public function saveOrUpdate($campaign)
    {
        $this->em->beginTransaction();
        $this->em->persist($campaign);
        $this->em->flush();
        $this->em->commit();
        return $campaign;
    }

    /**
     * @param $campaignParticipant CampaignParticipants
     * @return mixed CampaignParticipants
     */
    public function saveOrUpdateCampaignParticipant($campaignParticipant)
    {
        $this->em->beginTransaction();
        $this->em->persist($campaignParticipant);
        $this->em->flush();
        $this->em->commit();
        return $campaignParticipant;
    }
}