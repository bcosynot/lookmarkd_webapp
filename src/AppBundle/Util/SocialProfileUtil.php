<?php
namespace AppBundle\Util;

use AppBundle\Core\Service\SocialServiceInterface;
use AppBundle\Entity\User;
use AppBundle\Core\Service\UserServiceInterface;
use Monolog\Logger;
use Sonata\NotificationBundle\Backend\BackendInterface;

class SocialProfileUtil
{

    /**
     *
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var SocialServiceInterface
     */
    private $socialService;

    /**
     *
     * @var Logger
     */
    private $logger;

    /**
     * @var BackendInterface
     */
    private $sonataBackend;

    public function __construct(UserServiceInterface $userService, Logger $logger,
                                SocialServiceInterface $socialService, BackendInterface $sonataBackend)
    {
        $this->userService = $userService;
        $this->logger = $logger;
        $this->socialService = $socialService;
        $this->sonataBackend = $sonataBackend;
    }

    public function getNextOnboardingStep(User $user)
    {
        $userProfile = $this->userService->getUserProfile($user);
        if (null == $userProfile) {
            return 'postingcategories';
        }
        $postingCategories = $userProfile->getCategories();
        if (null == $postingCategories || (null != $postingCategories && sizeof($postingCategories) == 0)) {
            return 'postingcategories';
        }
        if (null == $userProfile->getBloggerName() || (null != $userProfile->getBloggerName() && sizeof($userProfile->getBloggerName()) == 0)) {
            return 'bloggername';
        }
        return null;
    }

    public function updateSocialStatisticsIfNecessary(User $user)
    {
        $followerCount = $this->socialService->getMostRecentFollowerCount($user);
        if ($this->isNecessaryToUpdateSocialStatistics($followerCount)) {
            $this->updateSocialStatistics($user);
        }
    }

    public function updateSocialStatistics(User $user)
    {
        $this->logger->info('sending event');
        $this->sonataBackend->createAndPublish('stats',
            array(
                'username' => $user->getUsername(),
            ));
    }

    /**
     * @param $followerCount
     * @return bool
     */
    public function isNecessaryToUpdateSocialStatistics($followerCount)
    {
        $currentTime = new \DateTime();
        $currentTime->setTimestamp(time());
        return null == $followerCount || (null != $followerCount && sizeof($followerCount) > 0 && $currentTime->diff($followerCount[0]->getRecordedAt())->h > 5);
    }

}