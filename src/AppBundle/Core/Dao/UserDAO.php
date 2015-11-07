<?php

namespace AppBundle\Core\Dao;

use AppBundle\Entity\SocialProfile;
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
		$this->em->commit ();
		return $userProfile;
	}
	public function saveSocialProfile(SocialProfile $socialProfile) {
		$this->em->beginTransaction ();
		$this->em->persist ( $socialProfile );
		$this->em->commit ();
		return $socialProfile;
	}
}