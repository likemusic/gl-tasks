<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEmailType extends EntityType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		/*        $builder
					->add('email')
				;*/
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'class' => User::class,
			'choice_label' => 'username',
		]);
	}
}
