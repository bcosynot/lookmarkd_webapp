<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Core\Service\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser implements ParticipantInterface
{
	
	const USER_TYPE_INFLUENCER = 1;
	const USER_TYPE_BRAND = 2;
	
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $instagramId;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $instagramAccessToken;
    
    /**
     *
     * @ManyToMany(targetEntity="User")
     * @JoinTable(name="connections")
     */
    private $connections;
    
    /**
     * @ORM\Column(type="integer", name="user_type", nullable=true)
     * @var integer
     */
    private $userType;
        
    /**
     * Set instagramId
     *
     * @param string $instagramId
     *
     * @return User
     */
    public function setInstagramId($instagramId)
    {
        $this->instagramId = $instagramId;

        return $this;
    }

    /**
     * Get instagramId
     *
     * @return string
     */
    public function getInstagramId()
    {
        return $this->instagramId;
    }

    /**
     * Set instagramAccessToken
     *
     * @param string $instagramAccessToken
     *
     * @return User
     */
    public function setInstagramAccessToken($instagramAccessToken)
    {
        $this->instagramAccessToken = $instagramAccessToken;

        return $this;
    }

    /**
     * Get instagramAccessToken
     *
     * @return string
     */
    public function getInstagramAccessToken()
    {
        return $this->instagramAccessToken;
    }

    /**
     * Set instagramProfilePicture
     *
     * @param string $instagramProfilePicture
     *
     * @return User
     */
    public function setInstagramProfilePicture($instagramProfilePicture)
    {
        $this->instagramProfilePicture = $instagramProfilePicture;

        return $this;
    }

    /**
     * Get instagramProfilePicture
     *
     * @return string
     */
    public function getInstagramProfilePicture()
    {
        return $this->instagramProfilePicture;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

	/**
	 * {@inheritDoc}
	 * @see \FOS\MessageBundle\Model\ParticipantInterface::getId()
	 */
	public function getId() {
		return $this->id;
	}


    /**
     * Add connection
     *
     * @param \AppBundle\Entity\User $connection
     *
     * @return User
     */
    public function addConnection(\AppBundle\Entity\User $connection)
    {
        $this->connections[] = $connection;

        return $this;
    }

    /**
     * Remove connection
     *
     * @param \AppBundle\Entity\User $connection
     */
    public function removeConnection(\AppBundle\Entity\User $connection)
    {
        $this->connections->removeElement($connection);
    }

    /**
     * Get connections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConnections()
    {
        return $this->connections;
    }


    /**
     * Set userType
     *
     * @param integer $userType
     *
     * @return User
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return integer
     */
    public function getUserType()
    {
        return $this->userType;
    }
}
