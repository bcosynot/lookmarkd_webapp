<?php

namespace AppBundle\Security\Core\User;

use AppBundle\Core\Service\UserServiceInterface;
use AppBundle\Entity\SocialProfile;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProfile;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Monolog\Logger;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass {
	
	/**
	 * Instagram client id
	 *
	 * @var string
	 */
	private $instagramClientId;
	
	/**
	 * Instagram client secret.
	 *
	 * @var string
	 */
	private $instagramClientSecret;
	
	/**
	 *
	 * @var Logger
	 */
	private $logger;
	
	/**
	 *
	 * @var UserServiceInterface
	 */
	private $userService;
	
	/**
	 * Dependency injection.
	 *
	 * @param unknown $userManager        	
	 * @param unknown $properties        	
	 * @param unknown $instagramClientId        	
	 * @param unknown $instagramClientSecret        	
	 * @param Logger $logger        	
	 * @param UserServiceInterface $userService        	
	 */
	public function __construct($userManager, $properties, $instagramClientId, $instagramClientSecret, Logger $logger, UserServiceInterface $userService) {
		parent::__construct ( $userManager, $properties );
		$this->instagramClientId = $instagramClientId;
		$this->instagramClientSecret = $instagramClientSecret;
		$this->logger = $logger;
		$this->userService = $userService;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 *
	 */
	public function connect(UserInterface $user, UserResponseInterface $response) {
		$this->logger->info ( "in connect" );
		$property = $this->getProperty ( $response );
		$username = $response->getUsername ();
		
		// on connect - get the access token and the user ID
		$service = $response->getResourceOwner ()->getName ();
		
		$setter = 'set' . ucfirst ( $service );
		$setter_id = $setter . 'Id';
		$setter_token = $setter . 'AccessToken';
		
		// we "disconnect" previously connected users
		if (null !== $previousUser = $this->userManager->findUserBy ( array (
				$property => $username 
		) )) {
			$previousUser->$setter_id ( null );
			$previousUser->$setter_token ( null );
			$this->userManager->updateUser ( $previousUser );
		}
		
		// we connect current user
		$user->$setter_id ( $username );
		$user->$setter_token ( $response->getAccessToken () );
		
		$this->userManager->updateUser ( $user );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
		$username = $response->getUsername ();
		$user = $this->userManager->findUserBy ( array (
				$this->getProperty ( $response ) => $username 
		) );
		// when the user is registrating
		if (null === $user) {
			$service = $response->getResourceOwner ()->getName ();
			$setter = 'set' . ucfirst ( $service );
			$setter_id = $setter . 'Id';
			$setter_token = $setter . 'AccessToken';
			// create new user here
			$user = $this->userManager->createUser ();
			$user->$setter_id ( $username );
			$user->$setter_token ( $response->getAccessToken () );
			// I have set all requested data with the user's username
			// modify here with relevant data
			$user->setUsername ( $response->getNickname () );
			$user->setEmail ( '' );
			$user->setPassword ( $response->getAccessToken () );
			$user->setEnabled ( true );
			$user->setUserType(User::USER_TYPE_INFLUENCER);
			$this->userManager->updateUser ( $user );
			$userProfile = new UserProfile ();
			$realName = $response->getRealName ();
			$firstName = '';
			$lastName = '';
			if(strpos($realName, ' ')!==false) {
				$names = explode(' ', $realName);
				$firstName = $names[0];
				$lastName = end($names);
			}
			$userProfile->setFirstName ( $firstName );
			$userProfile->setLastName ( $lastName );
			$userProfile->setUser ( $user );
			$this->userService->saveUserProfile ( $userProfile );
			$socialProfile = new SocialProfile ();
			$socialProfile->setProviderType ( 'instagram' );
			$socialProfile->setUser ( $user );
			$socialProfile->setProfilePicture($response->getProfilePicture());
			$this->userService->saveSocialProfile($socialProfile);
			return $user;
		}
		
		// if user exists - go with the HWIOAuth way
		$user = parent::loadUserByOAuthUserResponse ( $response );
		
		$serviceName = $response->getResourceOwner ()->getName ();
		$setter = 'set' . ucfirst ( $serviceName ) . 'AccessToken';
		
		// update access token
		$user->$setter ( $response->getAccessToken () );

		if(null ==  $user->getUserType() || 0 == $user->getUsertype()) {
			$user->setUserType(User::USER_TYPE_INFLUENCER);
		}
		$this->userManager->updateUser ( $user );

		return $user;
	}
	public function setRouter($router) {
		$this->router = $router;
	}
	public function setInstagramClientId($instagramClientId) {
		$this->instagramClientId = $instagramClientId;
	}
	public function setInstagramClientSecret($instagramClientSecret) {
		$this->instagramClientSecret = $instagramClientSecret;
	}
	public function setLogger($logger) {
		$this->logger = $logger;
	}
}