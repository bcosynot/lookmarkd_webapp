<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 13-02-2016
 * Time: 12:48 PM
 */

namespace AppBundle\Core\Service;

use AppBundle\Core\Dao\SocialStatisticDAO;
use AppBundle\Entity\SocialStatistic;
use AppBundle\Entity\User;
use Monolog\Logger;

class SocialService implements SocialServiceInterface
{

    /**
     * DAO for user.
     *
     * @var SocialStatisticDAO
     */
    private $socialStatisticDAO;

    /**
     * Logging handler.
     *
     * @var Logger
     */
    private $logger;
    public function __construct(SocialStatisticDAO $userDAO, Logger $logger) {
        $this->socialStatisticDAO = $userDAO;
        $this->logger = $logger;
    }

    /**
     * @param SocialStatistic $socialStatistic
     */
    public function saveStatistic(SocialStatistic $socialStatistic)
    {
        $this->socialStatisticDAO->saveSocialStatistic($socialStatistic);
    }

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentFollowerCount(User $user)
    {
        return $this->socialStatisticDAO->getMostRecentFollowerCount($user);
    }

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentMediaCount(User $user)
    {
        return $this->socialStatisticDAO->getMostRecentMediaCount($user);
    }

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentMediaCommentsCount(User $user)
    {
        return $this->socialStatisticDAO->getMostRecentMediaCommentsCount($user);
    }

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentMediaLikesCount(User $user)
    {
        return $this->socialStatisticDAO->getMostRecentMediaLikesCount($user);
    }
}