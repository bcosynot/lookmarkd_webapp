<?php

namespace AppBundle\Core\Dao;

use AppBundle\Entity\PostingCategory;
use AppBundle\Entity\SocialProfile;
use AppBundle\Entity\ThreadMetadata;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProfile;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

/**
 * DAO for user related entities.
 *
 * @author Vivek Ranjan
 *        
 */
class UserDAO {
	
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
	public function saveUserProfile(UserProfile $userProfile) {
		$this->em->beginTransaction ();
		$this->em->persist ( $userProfile );
		$this->em->flush();
		$this->em->commit ();
		return $userProfile;
	}
	public function saveSocialProfile(SocialProfile $socialProfile) {
		$this->em->beginTransaction ();
		$this->em->persist ( $socialProfile );
		$this->em->flush();
		$this->em->commit ();
		return $socialProfile;
	}
	
	public function getPostingCateogiresForUser(User $user){
		return $this->em->getRepository("AppBundle:UserProfile")->findOneBy(array('user'=>$user))->getCategories();
	}
	
	/**
	 * 
	 * @param User $user
	 * @return UserProfile found by user
	 */
	public function getUserProfile(User $user) {
		return $this->em->getRepository('AppBundle:UserProfile')->findOneBy(array('user'=>$user));
	}
	
	/**
	 * 
	 * @param int $postingCategoryId
	 * @return PostingCategory Found from ID.
	 */
	public function getPostingCategory($postingCategoryId) {
		return $this->em->getRepository('AppBundle:PostingCategory')->find($postingCategoryId);
	}
	
	/**
	 * 
	 * @param string $username
	 * return User
	 */
	public function getUser($username) {
		return $this->em->getRepository('AppBundle:User')->findOneBy(array('username'=>$username));
	}
	
	/**
	 * @param User $user
	 * @return array Threads user is a part of
	 */
	public function getAssociatedThreads(User $user) {
		$threadMetadatas = $this->em->getRepository('AppBundle:ThreadMetadata')->findBy(array('participant'=>$user));
		$threads = array();
		foreach ($threadMetadatas as $threadMetadata) {
			$threads[] = $threadMetadata->getThread();
		}
		return $threads;
	}
	
}
