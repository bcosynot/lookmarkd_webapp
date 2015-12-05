<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\MessageMetadata as BaseMessageMetadata;

/**
 * @ORM\Entity
 */
class MessageMetadata extends BaseMessageMetadata
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(
	 *   targetEntity="AppBundle\Entity\Message",
	 *   inversedBy="metadata"
	 * )
	 * @var \FOS\MessageBundle\Model\MessageInterface
	 */
	protected $message;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
	 * @var \FOS\MessageBundle\Model\ParticipantInterface
	 */
	protected $participant;
}
