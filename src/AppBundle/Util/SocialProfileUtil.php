<?php
namespace AppBundle\Util;

use AppBundle\Entity\User;
use AppBundle\Core\Service\UserServiceInterface;
use Monolog\Logger;
class SocialProfileUtil {
	
	/**
	 * 
	 * @var UserServiceInterface
	 */
	private $userService;
	
	/**
	 * 
	 * @var Logger
	 */
	private $logger;
	
	public function __construct(UserServiceInterface $userService, Logger $logger) {
		$this->userService = $userService;
		$this->logger = $logger;
	}
	
	public function getNextOnboardingStep(User $user) {
		$userProfile = $this->userService->getUserProfile($user);
		$postingCategories = $userProfile->getCategories();
		if(null==$postingCategories || (null!=$postingCategories && sizeof($postingCategories) == 0)) {
			return 'postingcategories';
		}
		if(null==$userProfile->getBloggerName() || (null!=$userProfile->getBloggerName() && sizeof($userProfile->getBloggerName()) == 0)) {
			return 'bloggername';
		}
		return null;
	}

}