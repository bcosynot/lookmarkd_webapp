<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CampaignParticipants
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CampaignParticipants
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="campaign", type="bigint")
     */
    private $campaign;

    /**
     * @var integer
     *
     * @ORM\Column(name="participant", type="bigint")
     */
    private $participant;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set campaign
     *
     * @param integer $campaign
     *
     * @return CampaignParticipants
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return integer
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Set participant
     *
     * @param integer $participant
     *
     * @return CampaignParticipants
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get participant
     *
     * @return integer
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CampaignParticipants
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}

