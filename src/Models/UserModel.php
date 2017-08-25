<?php

namespace Demo\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * CashPoolModel
 * @ORM\Table(
 *     name="users",
 * )
 * @ORM\Entity
 */
class UserModel
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string")
	 */
	private $name;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="age", type="integer")
	 */
	private $age;
}