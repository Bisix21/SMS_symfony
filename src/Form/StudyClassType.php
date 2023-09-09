<?php

namespace App\Form;

use App\Entity\StudyClass;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudyClassType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('number', TextType::class)
			->add('description', TextType::class, [
				'required' => false
			])
			->add('user', EntityType::class, [
				'class' => User::class,
				'choices' => $options['student'],
				'multiple' => true,
				'expanded' => false,
				'label' => 'Select user:',
				'choice_label' => fn($user) => $user->getFullName(),
				'required' => false
			])->add('classmate', EntityType::class, [
				'class' => User::class,
				'choices' => $options['classmate'],
				'label' => 'Select classmate',
				'choice_label' => fn($user) => $user->getFullName(),
				'mapped' => false,
				'placeholder' => 'Select classmate',
				'required' => false
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => StudyClass::class,
			'student' => User::class,
			'classmate' => User::class
		]);
	}
}
