<?php

namespace AppBundle\Core\Dao;


use AppBundle\Entity\Campaign;
use AppBundle\Entity\CampaignParticipants;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Monolog\Logger;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

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

    /**
     * @param User $user
     * @return array
     */
    public function getNewRequests($user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('cp')
                ->from('AppBundle\Entity\CampaignParticipants', 'cp')
                ->join('cp.campaign', 'c')
                ->where('cp.participant = :user')
                ->andWhere('cp.status = :requestStatus')
                ->setParameter('user', $user)
                ->setParameter('requestStatus', CampaignParticipants::STATUS_REQUESTED)
                ->addSelect('c');
        return $qb->getQuery()->getResult();
    }

    public function updateCampaignParticipantStatus($campaignParticipantId, $status)
    {
        $q = $this->em->createQuery('UPDATE AppBundle\Entity\CampaignParticipants c SET c.status = :status WHERE c.id = :id');
        $q->setParameter('status', $status);
        $q->setParameter('id', $campaignParticipantId);
        $q->execute();
    }

    public function getAcceptedRequests($user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('cp')
            ->from('AppBundle\Entity\CampaignParticipants', 'cp')
            ->join('cp.campaign', 'c')
            ->where('cp.participant = :user')
            ->andWhere('cp.status = :requestStatus')
            ->setParameter('user', $user)
            ->setParameter('requestStatus', CampaignParticipants::STATUS_ACCEPTED)
            ->addSelect('c')
            ->orderBy('c.start');
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $user
     * @return Campaign[]
     */
    public function getActiveRequestsCreatedByUser($user)
    {
        $currentDate = $this->getCurrentDateTime();

        return $this->em->createQueryBuilder()
                            ->select('c')
                            ->from('AppBundle\Entity\Campaign', 'c')
            ->where('c.owner = :user')
            ->andWhere('c.start <= :currentDate')
            ->andWhere('c.end >= :currentDate')
            ->setParameter('currentDate', $currentDate)
            ->setParameter('user', $user)
            ->getQuery()->getResult();
    }

    public function getCampaignParticipantsForCampaignIds($campaignIds)
    {
        return $this->em->createQueryBuilder()
            ->select('cp')
            ->from('AppBundle\Entity\CampaignParticipants', 'cp')
            ->join('cp.campaign', 'c')
            ->where('c.id IN (:campaignIds)')
            ->setParameter('campaignIds', $campaignIds)
            ->getQuery()
            ->getResult();
    }

    public function getCampaignParticipants($campaignParticipantId)
    {
        return $this->em->getRepository('AppBundle:CampaignParticipants')->find($campaignParticipantId);
    }

    public function getCompletedRequests($user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('cp')
            ->from('AppBundle\Entity\CampaignParticipants', 'cp')
            ->join('cp.campaign', 'c')
            ->where('cp.participant = :user')
            ->andWhere('cp.status = :requestStatus')
            ->setParameter('user', $user)
            ->setParameter('requestStatus', CampaignParticipants::STATUS_COMPLETED)
            ->addSelect('c')
            ->orderBy('c.start');
        return $qb->getQuery()->getResult();
    }

    public function getRequestsDueSoon($user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('cp')
            ->from('AppBundle\Entity\CampaignParticipants', 'cp')
            ->join('cp.campaign', 'c')
            ->where('cp.participant = :user')
            ->andWhere('cp.status = :requestStatus')
            ->andWhere('DATE_DIFF(CURRENT_DATE(), c.end) <= 3')
            ->setParameter('user', $user)
            ->setParameter('requestStatus', CampaignParticipants::STATUS_ACCEPTED)
            ->addSelect('c')
            ->orderBy('DATE_DIFF(CURRENT_DATE(), c.end)');
        return $qb->getQuery()->getResult();
    }

    /**
     * @return \DateTime
     */
    public function getCurrentDateTime()
    {
        $currentDate = new \DateTime();
        $currentDate->setTimestamp(time());
        return $currentDate;
    }

    /**
     * @param $user
     * @return Campaign[]
     */
    public function getEndedRequestsCreatedByUser($user)
    {
        $currentDate = $this->getCurrentDateTime();

        return $this->em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle\Entity\Campaign', 'c')
            ->where('c.owner = :user')
            ->andWhere('c.end <= :currentDate')
            ->setParameter('currentDate', $currentDate)
            ->setParameter('user', $user)
            ->getQuery()->getResult();
    }
}