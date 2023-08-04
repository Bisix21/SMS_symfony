<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email')
			->add('roles', ChoiceType::class, [
				'choices' => $options['roles'],
				'multiple' => true,
				'expanded' => true,
				'attr' => [
					'class' => 'role-line'
				]
			])
			->add('password')
			->add('first_name')
			->add('name')
			->add('sur_name')
			->add('birthday', BirthdayType::class, [
				'widget' => 'choice',
				'input' => 'datetime_immutable'
			])
			->add('is_verified', CheckboxType::class, [
				'required' => false
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => User::class,
			'roles' => []
		]);
	}
}
