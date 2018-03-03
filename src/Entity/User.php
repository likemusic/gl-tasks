<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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

	/** @inheritdoc */
	public function setEmail($email)
	{
		$email = is_null($email) ? '' : $email;
		parent::setEmail($email);
		$this->setUsername($email);

		return $this;
	}
}
