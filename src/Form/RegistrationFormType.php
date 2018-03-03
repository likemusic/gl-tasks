<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class RegistrationFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);

		$builder->remove('username');
		$builder->remove('plainPassword');
		$builder->add('plainPassword', PasswordType::class, [
			'translation_domain' => 'FOSUserBundle',
			'attr' => [
				'autocomplete' => 'new-password',
			],
			'label' => 'form.password',
		]);
	}

	public function getParent()
	{
		return BaseRegistrationFormType::class;
	}

	public function getBlockPrefix()
	{
		return 'app_user_registration';
	}

	// For Symfony 2.x
	public function getName()
	{
		return $this->getBlockPrefix();
	}
}
