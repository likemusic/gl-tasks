<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank
	 */
	private $text;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(type="datetime")
	 * @Assert\DateTime
	 */
	private $date;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $author;

	/**
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getText(): string
	{
		return $this->text;
	}

	/**
	 * @param string $text
	 * @return Comment
	 */
	public function setText(string $text): Comment
	{
		$this->text = $text;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate(): \DateTime
	{
		return $this->date;
	}

	/**
	 * @param \DateTime $date
	 * @return Comment
	 */
	public function setDate(\DateTime $date): Comment
	{
		$this->date = $date;
		return $this;
	}

	/**
	 * @return User
	 */
	public function getAuthor(): User
	{
		return $this->author;
	}

	/**
	 * @param User $author
	 * @return Comment
	 */
	public function setAuthor(User $author): Comment
	{
		$this->author = $author;
		return $this;
	}

	/**
	 * @return Task
	 */
	public function getTask(): Task
	{
		return $this->task;
	}

	/**
	 * @param Task $task
	 * @return Comment
	 */
	public function setTask(Task $task): Comment
	{
		$this->task = $task;
		return $this;
	}
}
