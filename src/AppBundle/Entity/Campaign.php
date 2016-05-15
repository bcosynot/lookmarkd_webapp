<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Campaign
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
     * @var string
     *
     * @ORM\Column(name="campaign_name", type="string", length=255)
     */
    private $campaignName;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetimetz")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetimetz")
     */
    private $end;

    /**
     * @var integer
     *
     * @ORM\Column(name="cash_reward", type="integer")
     */
    private $cashReward;

    /**
     * @var string
     *
     * @ORM\Column(name="kind_reward", type="string")
     */
    private $kindReward;

    /**
     * @var string
     *
     * @ORM\Column(name="brief", type="string")
     */
    private $brief;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_posts", type="integer")
     */
    private $numPosts;

    /**
     * @var string
     *
     * @ORM\Column(name="handles", type="string")
     */
    private $handles;

    /**
     * @var string
     *
     * @ORM\Column(name="hashtags", type="string")
     */
    private $hashtags;

    /**
     * @var string
     *
     * @ORM\Column(name="msg_subject", type="string")
     */
    private $msgSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="msg_body", type="string")
     */
    private $msgBody;

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
     * Set campaignName
     *
     * @param string $campaignName
     *
     * @return Campaign
     */
    public function setCampaignName($campaignName)
    {
        $this->campaignName = $campaignName;

        return $this;
    }

    /**
     * Get campaignName
     *
     * @return string
     */
    public function getCampaignName()
    {
        return $this->campaignName;
    }

    /**
     * Set owner
     *
     * @param integer $owner
     *
     * @return Campaign
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return integer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Campaign
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Campaign
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getCashReward()
    {
        return $this->cashReward;
    }

    /**
     * @param int $cashReward
     */
    public function setCashReward($cashReward)
    {
        $this->cashReward = $cashReward;
    }

    /**
     * @return string
     */
    public function getKindReward()
    {
        return $this->kindReward;
    }

    /**
     * @param string $kindReward
     */
    public function setKindReward($kindReward)
    {
        $this->kindReward = $kindReward;
    }

    /**
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * @param string $brief
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;
    }

    /**
     * @return int
     */
    public function getNumPosts()
    {
        return $this->numPosts;
    }

    /**
     * @param int $numPosts
     */
    public function setNumPosts($numPosts)
    {
        $this->numPosts = $numPosts;
    }

    /**
     * @return string
     */
    public function getHandles()
    {
        return $this->handles;
    }

    /**
     * @param string $handles
     */
    public function setHandles($handles)
    {
        $this->handles = $handles;
    }

    /**
     * @return string
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * @param string $hashtags
     */
    public function setHashtags($hashtags)
    {
        $this->hashtags = $hashtags;
    }

    /**
     * @return string
     */
    public function getMsgSubject()
    {
        return $this->msgSubject;
    }

    /**
     * @param string $msgSubject
     */
    public function setMsgSubject($msgSubject)
    {
        $this->msgSubject = $msgSubject;
    }

    /**
     * @return string
     */
    public function getMsgBody()
    {
        return $this->msgBody;
    }

    /**
     * @param string $msgBody
     */
    public function setMsgBody($msgBody)
    {
        $this->msgBody = $msgBody;
    }

}

