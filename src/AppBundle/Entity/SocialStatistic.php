<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialStatistic
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SocialStatistic
{
    const STAT_TYPE_FOLLOWERS = 1;
    const STAT_TYPE_MEDIA_LIKES = 2;
    const STAT_TYPE_MEDIA_COUNT = 3;
    const STAT_TYPE_MEDIA_COMMENTS = 4;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\Column(name="user", type="integer")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="provider_type", type="string")
     */
    private $providerType;

    /**
     * @var integer
     *
     * @ORM\Column(name="statistics_type", type="integer")
     */
    private $statisticsType;

    /**
     * @var \DateTimeZone
     *
     * @ORM\Column(name="recorded_at", type="datetimetz")
     */
    private $recordedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="statistic", type="bigint")
     */
    private $statistic;


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
     * Set providerType
     *
     * @param string $providerType
     *
     * @return SocialStatistic
     */
    public function setProviderType($providerType)
    {
        $this->providerType = $providerType;

        return $this;
    }

    /**
     * Get providerType
     *
     * @return string
     */
    public function getProviderType()
    {
        return $this->providerType;
    }

    /**
     * Set statisticsType
     *
     * @param integer $statisticsType
     *
     * @return SocialStatistic
     */
    public function setStatisticsType($statisticsType)
    {
        $this->statisticsType = $statisticsType;

        return $this;
    }

    /**
     * Get statisticsType
     *
     * @return integer
     */
    public function getStatisticsType()
    {
        return $this->statisticsType;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return SocialStatistic
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set recordedAt
     *
     * @param \DateTimeZone $recordedAt
     *
     * @return SocialStatistic
     */
    public function setRecordedAt($recordedAt)
    {
        $this->recordedAt = $recordedAt;

        return $this;
    }

    /**
     * Get recordedAt
     *
     * @return \DateTimeZone
     */
    public function getRecordedAt()
    {
        return $this->recordedAt;
    }

    /**
     * Set statistic
     *
     * @param integer $statistic
     *
     * @return SocialStatistic
     */
    public function setStatistic($statistic)
    {
        $this->statistic = $statistic;

        return $this;
    }

    /**
     * Get statistic
     *
     * @return integer
     */
    public function getStatistic()
    {
        return $this->statistic;
    }
}

