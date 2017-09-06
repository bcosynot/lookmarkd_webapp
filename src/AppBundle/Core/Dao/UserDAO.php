<?php

namespace AppBundle\Core\Dao;

use AppBundle\Entity\PostingCategory;
use AppBundle\Entity\SocialProfile;
use AppBundle\Entity\SocialStatistic;
use AppBundle\Entity\ThreadMetadata;
use AppBundle\Entity\User;
use AppBundle\Entity\UserPreference;
use AppBundle\Entity\UserPreferenceType;
use AppBundle\Entity\UserProfile;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

/**
 * DAO for user related entities.
 *
 * @author Vivek Ranjan
 *
 */
class UserDAO
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

    public function saveUserProfile(UserProfile $userProfile)
    {
        $this->em->beginTransaction();
        $this->em->persist($userProfile);
        $this->em->flush();
        $this->em->commit();
        return $userProfile;
    }

    public function saveSocialProfile(SocialProfile $socialProfile)
    {
        $this->em->beginTransaction();
        $this->em->persist($socialProfile);
        $this->em->flush();
        $this->em->commit();
        return $socialProfile;
    }

    public function getPostingCateogiresForUser(User $user)
    {
        return $this->em->getRepository("AppBundle:UserProfile")->findOneBy(array(
            'user' => $user
        ))->getCategories();
    }

    /**
     *
     * @param User $user
     * @return UserProfile found by user
     */
    public function getUserProfile(User $user)
    {
        return $this->em->getRepository('AppBundle:UserProfile')->findOneBy(array(
            'user' => $user
        ));
    }

    /**
     *
     * @param int $postingCategoryId
     * @return PostingCategory Found from ID.
     */
    public function getPostingCategory($postingCategoryId)
    {
        return $this->em->getRepository('AppBundle:PostingCategory')->find($postingCategoryId);
    }

    /**
     *
     * @param string $username
     * return User
     */
    public function getUser($username)
    {
        return $this->em->getRepository('AppBundle:User')->findOneBy(array('username' => $username));
    }

    /**
     * @param User $user
     * @return array Threads user is a part of
     */
    public function getAssociatedThreads(User $user)
    {
        $threadMetadatas = $this->em->getRepository('AppBundle:ThreadMetadata')->findBy(array('participant' => $user));
        $threads = array();
        foreach ($threadMetadatas as $threadMetadata) {
            $threads[] = $threadMetadata->getThread();
        }
        return $threads;
    }

    public function getUsersWithNameLike($userNameLike)
    {
        $this->em->beginTransaction();
        $query = $this->em->createQuery('Select u FROM AppBundle\Entity\User WHERE u.username LIKE :userNameLike');
        $query->setParameter('userNameLike', '%' . $userNameLike . '%');
        $users = $query->getResult();
        return $users;
    }

    /**
     *
     * @param User $user
     * @param UserPreferenceType $preferenceType
     *            the preference to fetch
     */
    public function getUserPreference(User $user, UserPreferenceType $preferenceType)
    {
        return $this->em->getRepository('AppBundle:UserPreference')->findOneBy(array(
            'user' => $user,
            'preferenceType' => $preferenceType
        ));
    }

    /**
     *
     * @param UserPreference $userPreference
     */
    public function setUserPreference(UserPreference $userPreference)
    {
        $this->em->beginTransaction();
        $this->em->persist($userPreference);
        $this->em->flush();
        $this->em->commit();
        return $userPreference;
    }

    /**
     * Get all existing preferences for user
     *
     * @param User $user
     * @return array of @link UserPreferences
     */
    public function getUserPreferences(User $user)
    {
        return $this->em->getRepository('AppBundle:UserPreference')->findAll(array(
            'user' => $user
        ));
    }

    /**
     * Get @link UserPreferenceType
     * @param string $preferenceKey
     */
    public function getUserPreferenceType($preferenceKey)
    {
        return $this->em->getRepository('AppBundle:UserPreferenceType')->findOneBy(array(
            'preferenceKey' => $preferenceKey
        ));
    }

    /**
     * @return array
     */
    public function getAllUserPreferenceTypes()
    {
        return $this->em->getRepository('AppBundle:UserPreferenceType')->findAll();
    }


    /**
     * @return \AppBundle\Entity\User[]|array
     */
    public function getAllInfluencers()
    {
        return $this->em->getRepository('AppBundle:User')->findBy(array(
            'userType' => 1
        ));
    }

    /**
     * @param User $user
     * @return SocialProfile|null|object
     */
    public function getSocialProfile($user)
    {
        return $this->em->getRepository('AppBundle:SocialProfile')->findOneBy(
            array('user' => $user)
        );
    }

    /**
     * @param $categoryIds
     * @param $followerCount
     * @return array
     */
    public function getInfluencers($categoryIds, $followerCount)
    {
        $qb = $this->em->createQueryBuilder();
        /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        $qb
            ->select('u')
            ->from('AppBundle\Entity\UserProfile', 'up')
            ->leftJoin('AppBundle\Entity\User'
                        , 'u'
                        , \Doctrine\ORM\Query\Expr\Join::WITH
                        , 'u = up.user')
            ->leftJoin('AppBundle\Entity\SocialStatistic'
                , 'ss'
                , \Doctrine\ORM\Query\Expr\Join::WITH
                , 'ss.user = up.user')
            ->leftJoin('up.categories', 'category')
            ->where('ss.providerType = :providerType')
            ->andWhere('ss.statisticsType = :statType')
            ->andWhere('ss.statistic >= :statistic')
            ->andWhere('u.userType = :userType')
            ->andWhere('category IN (:categoryIds)')
            ->setParameter('providerType', 'instagram')
            ->setParameter('statType', SocialStatistic::STAT_TYPE_FOLLOWERS)
            ->setParameter('userType', User::USER_TYPE_INFLUENCER)
            ->setParameter('categoryIds', $categoryIds)
            ->setParameter('statistic', $followerCount);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $userId integer
     * @return User
     */
    public function getUserFromId($userId)
    {
        return $this->em->getRepository('AppBundle:User')->findOneBy(
            array('id'=>$userId)
        );
    }

}
