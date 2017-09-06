<?php
/**
 * Created by PhpStorm.
 * User: Vivek
 * Date: 13-02-2016
 * Time: 12:46 PM
 */

namespace AppBundle\Core\Service;


use AppBundle\Entity\SocialStatistic;
use AppBundle\Entity\User;

interface SocialServiceInterface
{
    public function saveStatistic(SocialStatistic $socialStatistic);

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentFollowerCount(User $user);

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentMediaCount(User $user);

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentMediaCommentsCount(User $user);

    /**
     * @param User $user
     * @return SocialStatistic[]|null
     */
    public function getMostRecentMediaLikesCount(User $user);

}