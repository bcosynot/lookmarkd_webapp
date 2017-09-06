<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_preference", uniqueConstraints={@UniqueConstraint(name="unique_preference", columns={"user_id", "preference_type_id"})})
 */
class UserPreference {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 *
	 * @ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 *
	 * @var User User the setting belongs to
	 */
	private $user;
	
	/**
	 * @OneToOne(targetEntity="AppBundle\Entity\UserPreferenceType")
	 * @JoinColumn(name="preference_type_id", referencedColumnName="id")
	 * 
	 * @var UserPreferenceType identifier or key for the setting
	 */
	private $preferenceType;
	
	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	private $value;
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set value
	 *
	 * @param string $value        	
	 *
	 * @return UserPreference
	 */
	public function setValue($value) {
		$this->value = $value;
		
		return $this;
	}
	
	/**
	 * Get value
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * Set user
	 *
	 * @param \AppBundle\Entity\User $user        	
	 *
	 * @return UserPreference
	 */
	public function setUser(\AppBundle\Entity\User $user = null) {
		$this->user = $user;
		
		return $this;
	}
	
	/**
	 * Get user
	 *
	 * @return \AppBundle\Entity\User
	 */
	public function getUser() {
		return $this->user;
	}
	
    /**
     * Set preferenceType
     *
     * @param string $preferenceType
     *
     * @return UserPreference
     */
    public function setPreferenceType($preferenceType)
    {
        $this->preferenceType = $preferenceType;

        return $this;
    }

    /**
     * Get preferenceType
     *
     * @return string
     */
    public function getPreferenceType()
    {
        return $this->preferenceType;
    }
}
