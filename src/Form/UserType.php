<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('email', EmailType::class,[
				'label' => 'Enter email:',
				'required' => true
			])
			->add('roles', ChoiceType::class, [
				'choices' => $options['roles'],
				'multiple' => true,
				'expanded' => true,
				'label'=>'Select roles for user:',
			])
			->add('password',PasswordType::class,[
				'label'=>'Enter password:'
			])
			->add('first_name', TextType::class,[
				'label'=>'Enter first name:',
				'required' => true
			])
			->add('name', TextType::class,[
				'label'=>'Enter name:',
				'required' => true
			])
			->add('sur_name', TextType::class,[
				'label'=>'Enter sur-name:',
				'required' => true
			])
			->add('birthday', BirthdayType::class, [
				'widget' => 'choice',
				'input' => 'datetime_immutable',
				'label' => 'Select birthday:',
				'required' => true
			])
			->add('verified', CheckboxType::class, [
				'required' => false,
				'label'=>'This account is verified'
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
