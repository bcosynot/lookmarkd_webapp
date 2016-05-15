<?php

namespace AppBundle\Core\Service;

use AppBundle\Entity\SocialProfile;
use AppBundle\Entity\UserProfile;
use AppBundle\Entity\User;
use AppBundle\Entity\UserPreference;
use AppBundle\Entity\UserPreferenceType;

/**
 * APIs related to the user.
 *
 * @author Vivek Ranjan
 */
interface UserServiceInterface {
	
	/**
	 * Saves the user profile
	 *
	 * @param UserProfile $userProfile
	 *        	The UserProfile to be saved.
	 */
	public function saveUserProfile(UserProfile $userProfile);
	
	/**
	 * Save the social profile.
	 * 
	 * @param SocialProfile $socialProfile        	
	 */
	public function saveSocialProfile(SocialProfile $socialProfile);
	
	public function getPostingCateogiresForUser(User $user);
	
	/**
	 * 
	 * @param User $user
	 * @param int $postingCategoryId
	 */
	public function addPostingCategory(User $user, $postingCategoryId);

	/**
	 *
	 * @param User $user
	 * @return UserProfile found by user
	 */
	public function getUserProfile(User $user);
	
	/**
	 * @param string $username
	 * @return User
	 */
	public function getUserFromUsername($username);
	
	/**
	 *
	 * @param User $user
	 * @param null|string $userNameLike Fetch recipients whose username contains this string
	 * @return array
	 */
	public function getPossibleRecipientsForUser(User $user, $userNameLike);
	
	/**
	 * 
	 * @param User $user
	 * @param string $preferenceKey the preference to fetch
	 */
	public function getUserPreference(User $user, $preferenceKey);
	
	/**
	 * @param UserPreference $userPreference
	 */
	public function setUserPreference(UserPreference $userPreference);
	
	/**
	 * Get all existing preferences for user
	 * @param User $user
	 * @return array
	 */
	public function getUserPreferences(User $user);
	
	/**
	 * @return array
	 */
	public function getAllUserPreferenceTypes();
	
	/**
	 * @var string $preferenceKey
	 * @return UserPreferenceType
	 */
	public function getUserPreferenceType($preferenceKey);

	/**
	 * @return \AppBundle\Entity\User[]|array
	 */
	public function getAllInfluencers();

	/**
	 * @param User $user
	 * @return SocialProfile
	 */
	public function getSocialProfile($user);

	public function getInfluencers($categoryIds, $followerCount);

	/**
	 * @param $userId integer
	 * @return User
     */
	public function getUserFromId($userId);

}