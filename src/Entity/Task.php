<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
	const STATUS_NEW = 1;
	const STATUS_ACTIVE = 2;
	const STATUS_COMPLETE = 3;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank
	 */
	private $name;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank
	 */
	private $status;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $author;

	/**
	 * @var Comment[]|Collection
	 *
	 * @ORM\OneToMany(
	 *      targetEntity="Comment",
	 *      mappedBy="task",
	 *      orphanRemoval=true,
	 *      cascade={"persist"}
	 * )
	 * @ORM\OrderBy({"date": "DESC"})
	 */
	private $comments;

	/**
	 * @var User[]|Collection
	 *
	 * @ORM\ManyToMany(targetEntity="App\Entity\User")
	 * @ORM\JoinTable(name="task_executor")
	 * @ORM\OrderBy({"email": "ASC"})
	 */
	private $executors;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(type="datetime")
	 * @Assert\DateTime
	 */
	private $date;

	public function __construct()
	{
		$this->status = self::STATUS_NEW;
		$this->date = new \DateTime();
		$this->comments = new ArrayCollection();
		$this->executors = new ArrayCollection();
	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Task
	 */
	public function setName(string $name): Task
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return Task
	 */
	public function setDescription(string $description): Task
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getStatus(): int
	{
		return $this->status;
	}

	/**
	 * @param int $status
	 * @return Task
	 */
	public function setStatus(int $status): Task
	{
		$this->status = $status;
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
	 * @return Task
	 */
	public function setAuthor(User $author): Task
	{
		$this->author = $author;
		return $this;
	}

	/**
	 * @return Comment[]|Collection
	 */
	public function getComments(): Collection
	{
		return $this->comments;
	}

	/**
	 * @param Comment[]|Collection $comments
	 * @return Task
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;
		return $this;
	}

	/**
	 * @return User[]|Collection
	 */
	public function getExecutors(): Collection
	{
		return $this->executors;
	}

	/**
	 * @param User[]|ArrayCollection $executors
	 * @return Task
	 */
	public function setExecutors($executors)
	{
		$this->executors = $executors;
		return $this;
	}

	public function addExecutor(User $user)
	{
		$this->executors->add($user);
		return $this;
	}

	public function removeExecutor(User $user)
	{
		$this->executors->removeElement($user);
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
	 * @return Task
	 */
	public function setDate(\DateTime $date): Task
	{
		$this->date = $date;
		return $this;
	}
}
