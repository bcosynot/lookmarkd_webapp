<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Core\Service\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
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
     * @ORM\Column(type="string")
     */
    protected $instagramId;
        
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

}
