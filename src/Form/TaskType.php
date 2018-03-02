<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('description')
			->add('executors', CollectionType::class, [
				'entry_type' => EntityType::class,
				'prototype' => true,
				'allow_add' => true,
				'allow_delete' => true,
				'entry_options' => [
					'class' => User::class,
					'choice_label' => 'email',
					'label' => 'Executor email',
					'required' => true,
					'placeholder' => 'Please, choose executor',
				],
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Task::class,
		]);
	}
}
