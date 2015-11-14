<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\Thread as BaseThread;

/**
 * @ORM\Entity
 */
class Thread extends BaseThread
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @var \FOS\MessageBundle\Model\ParticipantInterface
	 */
	protected $createdBy;

	/**
	 * @ORM\OneToMany(
	 *   targetEntity="AppBundle\Entity\Message",
	 *   mappedBy="thread"
	 * )
	 * @var Message[]|\Doctrine\Common\Collections\Collection
	 */
	protected $messages;

	/**
	 * @ORM\OneToMany(
	 *   targetEntity="AppBundle\Entity\ThreadMetadata",
	 *   mappedBy="thread",
	 *   cascade={"all"}
	 * )
	 * @var ThreadMetadata[]|\Doctrine\Common\Collections\Collection
	 */
	protected $metadata;

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Add metadatum
     *
     * @param \AppBundle\Entity\ThreadMetadata $metadatum
     *
     * @return Thread
     */
    public function addMetadatum(\AppBundle\Entity\ThreadMetadata $metadatum)
    {
        $this->metadata[] = $metadatum;

        return $this;
    }

    /**
     * Remove metadatum
     *
     * @param \AppBundle\Entity\ThreadMetadata $metadatum
     */
    public function removeMetadatum(\AppBundle\Entity\ThreadMetadata $metadatum)
    {
        $this->metadata->removeElement($metadatum);
    }

    /**
     * Get metadata
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}
