<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Task;
use App\Form\CommentType;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TaskController
 * @package App\Controller
 * @Route("/tasks")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class TaskController extends Controller
{
	/**
	 * @Route("/", name="task_index")
	 * @param TaskRepository $taskRepository
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function index(TaskRepository $taskRepository)
	{
		$tasksPivotData = $taskRepository->getPivotData();

		return $this->render('task/index.html.twig', [
			'tasksInfo' => $tasksPivotData,
		]);
	}

	/**
	 * Creates a new Task entity.
	 *
	 * @Route("/new", name="task_new")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @return Response
	 */
	public function new(Request $request): Response
	{
		$task = new Task();
		$task->setAuthor($this->getUser());
		$form = $this->createForm(TaskType::class, $task);
		$form->add('submit', SubmitType::class, [
			'label' => 'Create',
			'attr' => ['class' => 'btn btn-primary pull-right'],
		]);

		$form->add('submit', SubmitType::class, [
			'label' => 'Create',
			'attr' => ['class' => 'btn btn-primary pull-right'],
		]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($task);
			$em->flush();

			$this->addFlash('success', 'task.created_successfully');

			return $this->redirectToRoute('task_index');
		}

		return $this->render('task/new.html.twig', [
			'post' => $task,
			'form' => $form->createView(),
		]);
	}

	/**
	 * Displays a form to edit an existing Task entity.
	 *
	 * @Route("/{id}/edit", requirements={"id": "\d+"}, name="task_edit")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @param Task $task
	 * @param TranslatorInterface $translator
	 * @return Response
	 */
	public function edit(Request $request, Task $task, TranslatorInterface $translator): Response
	{
		$form = $this->createForm(TaskType::class, $task);
		$form->add('submit', SubmitType::class, [
			'label' => 'Update',
			'attr' => ['class' => 'btn btn-primary pull-right'],
		]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', $translator->trans('task.updated_successfully'));

			return $this->redirectToRoute('task_edit', ['id' => $task->getId()]);
		}

		return $this->render('task/edit.html.twig', [
			'task' => $task,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="task_view")
	 * @Method({"GET", "POST"})
	 * @param Task $task
	 * @param Request $request
	 * @param TranslatorInterface $translator
	 * @return Response
	 */
	public function view(Task $task, Request $request, TranslatorInterface $translator): Response
	{
		$comment = new Comment();
		$comment->setAuthor($this->getUser());
		$form = $this->createForm(CommentType::class, $comment);

		$form->add('submit', SubmitType::class, [
			'label' => 'Submit',
			'attr' => ['class' => 'btn btn-primary pull-right'],
		]);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$comment->setTask($task);

			$em->persist($comment);
			$em->flush();

			$this->addFlash('success', $translator->trans('task.comment.created_successfully'));

			return $this->redirectToRoute('task_view', ['id' => $task->getId()]);
		}

		return $this->render('task/view.html.twig', ['task' => $task, 'commentForm' => $form->createView()]);
	}


}
