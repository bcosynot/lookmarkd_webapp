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
    const STATUS_REQUESTED = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_DECLINED = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_CANCELLED = 5;
    const STATUS_IGNORED = 6;
    
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Campaign",)
     * @ORM\JoinColumn(name="campaign", referencedColumnName="id")
     */
    private $campaign;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="participant", referencedColumnName="id")
     */
    private $participant;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var array
     * @ORM\Column(name="urls", type="simple_array")
     */
    private $urls;


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
     * @param $campaign
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
     * @return mixed
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Set participant
     *
     * @param $participant
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
     * @return mixed
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

    /**
     * @return array
     */
    public function getURLs()
    {
        return $this->urls;
    }

    /**
     * @param array $urls
     */
    public function setURLs($urls)
    {
        $this->urls = $urls;
    }

}

