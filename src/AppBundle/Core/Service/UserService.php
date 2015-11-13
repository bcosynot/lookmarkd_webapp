<?php

namespace AppBundle\Core\Service;

use AppBundle\AppBundle;
use AppBundle\Core\Dao\UserDAO;
use AppBundle\Core\Service\UserServiceInterface;
use AppBundle\Entity\SocialProfile;
use AppBundle\Entity\UserProfile;
use AppBundle\Entity\User;
use Monolog\Logger;
use AppBundle\Entity\UserPostingCategory;
use AppBundle\Entity\PostingCategory;

/**
 * API implementations related to user
 * 
 * @author Vivek
 *        
 */
class UserService implements UserServiceInterface {
	
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
	public function __construct(UserDAO $userDAO, Logger $logger) {
		$this->userDAO = $userDAO;
		$this->logger = $logger;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \AppBundle\Core\UserServiceInterface::saveUserProfile()
	 */
	public function saveUserProfile(UserProfile $userProfile) {
		$this->logger->debug ( "saving userprofile" );
		$this->userDAO->saveUserProfile ( $userProfile );
		return $userProfile;
	}
	
	
	public function saveSocialProfile(SocialProfile $socialProfile) {
		$this->logger->debug ( "saving userprofile" );
		$this->userDAO->saveSocialProfile ( $socialProfile );
		return $socialProfile;
	}
	
	public function getPostingCateogiresForUser(User $user) {
		return $this->userDAO->getPostingCateogiresForUser($user);
	}
	/**
	 * {@inheritDoc}
	 * @see \AppBundle\Core\Service\UserServiceInterface::addPostingCategory()
	 */
	public function addPostingCategory(User $user, $postingCategoryId) {
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
	public function getUserProfile(User $user) {
		return $this->userDAO->getUserProfile($user);
	}

}