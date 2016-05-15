<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 13-02-2016
 * Time: 12:52 PM
 */

namespace AppBundle\Core\Dao;

use AppBundle\Entity\SocialStatistic;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

class SocialStatisticDAO
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

    public function __construct(EntityManager $em, Logger $logger) {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function saveSocialStatistic($socialStatistic) {
        $this->em->beginTransaction();
        $this->em->persist($socialStatistic);
        $this->em->commit();
        $this->em->flush();
        $this->em->close();
    }

    /**
     * @param $user
     * @return \AppBundle\Entity\SocialStatistic
     */
    public function getMostRecentFollowerCount($user) {
        return $this->em->getRepository('AppBundle:SocialStatistic')
                            ->findBy(array(
                                'user' => $user,
                                'statisticsType' => SocialStatistic::STAT_TYPE_FOLLOWERS
                            ), array(
                                'recordedAt' => 'DESC'
                            ), 1);
    }

    /**
     * @param $user
     * @return \AppBundle\Entity\SocialStatistic
     */
    public function getMostRecentMediaCount($user) {
        return $this->em->getRepository('AppBundle:SocialStatistic')
                            ->findBy(array(
                                'user' => $user,
                                'statisticsType' => SocialStatistic::STAT_TYPE_MEDIA_COUNT
                            ), array(
                                'recordedAt' => 'DESC'
                            ), 1);
    }

    /**
     * @param $user
     * @return \AppBundle\Entity\SocialStatistic
     */
    public function getMostRecentMediaLikesCount($user) {
        return $this->em->getRepository('AppBundle:SocialStatistic')
                            ->findBy(array(
                                'user' => $user,
                                'statisticsType' => SocialStatistic::STAT_TYPE_MEDIA_LIKES
                            ), array(
                                'recordedAt' => 'DESC'
                            ), 1);
    }

    /**
     * @param $user
     * @return \AppBundle\Entity\SocialStatistic
     */
    public function getMostRecentMediaCommentsCount($user) {
        return $this->em->getRepository('AppBundle:SocialStatistic')
                            ->findBy(array(
                                'user' => $user,
                                'statisticsType' => SocialStatistic::STAT_TYPE_MEDIA_COMMENTS
                            ), array(
                                'recordedAt' => 'DESC'
                            ), 1);
    }

}