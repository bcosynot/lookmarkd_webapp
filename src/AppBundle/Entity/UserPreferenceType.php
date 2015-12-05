<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPreferenceType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserPreferenceType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="preferenceKey", type="string", length=255)
     */
    private $preferenceKey;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set preferenceKey
     *
     * @param string $preferenceKey
     *
     * @return UserPreferenceType
     */
    public function setPreferenceKey($preferenceKey)
    {
        $this->preferenceKey = $preferenceKey;

        return $this;
    }

    /**
     * Get preferenceKey
     *
     * @return string
     */
    public function getPreferenceKey()
    {
        return $this->preferenceKey;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return UserPreferenceType
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
