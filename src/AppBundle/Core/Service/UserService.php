<?php

namespace AppBundle\Core\Service;

use AppBundle\Core\Dao\UserDAO;
use AppBundle\Entity\SocialProfile;
use AppBundle\Entity\User;
use AppBundle\Entity\UserPreference;
use AppBundle\Entity\UserProfile;
use Monolog\Logger;

/**
 * API implementations related to user
 *
 * @author Vivek
 *
 */
class UserService implements UserServiceInterface
{

    /**
     * DAO for user.
     *
     * @var UserDAO
     */
    private $userDAO;

    /**
     * Logging handler.
     *
     * @var Logger
     */
    private $logger;

    public function __construct(UserDAO $userDAO, Logger $logger)
    {
        $this->userDAO = $userDAO;
        $this->logger = $logger;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\UserServiceInterface::saveUserProfile()
     */
    public function saveUserProfile(UserProfile $userProfile)
    {
        $this->logger->debug("saving userprofile");
        $this->userDAO->saveUserProfile($userProfile);
        return $userProfile;
    }

    public function saveSocialProfile(SocialProfile $socialProfile)
    {
        $this->logger->debug("saving userprofile");
        $this->userDAO->saveSocialProfile($socialProfile);
        return $socialProfile;
    }

    public function getPostingCateogiresForUser(User $user)
    {
        return $this->userDAO->getPostingCateogiresForUser($user);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\Service\UserServiceInterface::addPostingCategory()
     */
    public function addPostingCategory(User $user, $postingCategoryId)
    {
        $userProfile = $this->userDAO->getUserProfile($user);
        $postingCategory = $this->userDAO->getPostingCategory($postingCategoryId);
        $userProfile->addCategory($postingCategory);
        $this->userDAO->saveUserProfile($userProfile);
    }

    /**
     *
     * @param User $user
     * @return UserProfile found by user
     */
    public function getUserProfile(User $user)
    {
        return $this->userDAO->getUserProfile($user);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\Service\UserServiceInterface::getUser()
     */
    public function getUserFromUsername($username)
    {
        return $this->userDAO->getUser($username);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\Service\UserServiceInterface::getPossibleRecipientsForUser()
     */
    public function getPossibleRecipientsForUser(User $user, $userNameLike)
    {
        $recipients = array();
        $associatedThreads = $this->userDAO->getAssociatedThreads($user);
        if (null != $associatedThreads && sizeof($associatedThreads) > 0) {
            foreach ($associatedThreads as $associatedThread) {
                $participants = $associatedThread->getParticipants();
                if (null != $participants && sizeof($participants) > 0) {
                    foreach ($participants as $participant) {
                        if ($participant->getId() != $user->getId() && (null == $userNameLike || (null != $userNameLike && ($userNameLike === '' || !strpos($participant->getUsername(), $userNameLike))))) {
                            $recipients [] = $participant->getUsername();
                        }
                    }
                }
            }
        }
        $connections = $user->getConnections();
        if (null != $connections && sizeof($connections) > 0) {
            foreach ($connections as $connection) {
                if ($connection->getId() != $user->getId() && (null == $userNameLike || (null != $userNameLike && ($userNameLike === '' || !strpos($connection->getUsername(), $userNameLike))))) {
                    $recipients [] = $connection->getUsername();
                }
            }
        }
        return $recipients;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\Service\UserServiceInterface::getUserPreference()
     */
    public function getUserPreference(User $user, $preferenceKey)
    {
        return $this->userDAO->getUserPreference($user, $this->userDAO->getUserPreferenceType($preferenceKey));
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\Service\UserServiceInterface::setUserPreference()
     */
    public function setUserPreference(UserPreference $userPreference)
    {
        return $this->userDAO->setUserPreference($userPreference);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \AppBundle\Core\Service\UserServiceInterface::getUserPreferences()
     */
    public function getUserPreferences(User $user)
    {
        return $this->userDAO->getUserPreferences($user);
    }

    /**
     * {@inheritDoc}
     * @see \AppBundle\Core\Service\UserServiceInterface::getAllUserPreferenceTypes()
     */
    public function getAllUserPreferenceTypes()
    {
        return $this->userDAO->getAllUserPreferenceTypes();
    }

    /**
     * {@inheritDoc}
     * @see \AppBundle\Core\Service\UserServiceInterface::getUserPreferenceType()
     */
    public function getUserPreferenceType($preferenceKey)
    {
        return $this->userDAO->getUserPreferenceType($preferenceKey);
    }

    /**
     * @return \AppBundle\Entity\User[]|array
     */
    public function getAllInfluencers()
    {
        return $this->userDAO->getAllInfluencers();
    }


    public function getSocialProfile($user)
    {
        return $this->userDAO->getSocialProfile($user);
    }

    /**
     * @param $categoryIds
     * @param $followerCount
     * @return User[]
     */
    public function getInfluencers($categoryIds, $followerCount)
    {
        return $this->userDAO->getInfluencers($categoryIds, $followerCount);
    }

    /**
     * @param $userId integer
     * @return User
     */
    public function getUserFromId($userId)
    {
        return $this->userDAO->getUserFromId($userId);
    }
}