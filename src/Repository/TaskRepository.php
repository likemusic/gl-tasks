<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Task::class);
	}

	public function getPivotData()
	{
		$commentClass = Comment::class;
		$taskClass = Task::class;

		$dqlQuery = <<<EOT
SELECT t.id taskId, t.name taskName, a.id commentId, LENGTH(a.text) commentLength, ath.email commentAuthorEmail
FROM {$taskClass} t
LEFT JOIN t.comments a
LEFT JOIN {$commentClass} b
    WITH a.task = b.task
    AND LENGTH(a.text) < LENGTH(b.text)
LEFT JOIN {$commentClass} c
    WITH a.task = c.task
    AND LENGTH(a.text) = LENGTH(c.text)
    AND a.date < c.date
LEFT JOIN a.author ath
WHERE
	b IS NULL
	AND c IS NULL
GROUP BY t
EOT;

		return $this
			->getEntityManager()
			->createQuery($dqlQuery)
			->getResult();
	}
}
