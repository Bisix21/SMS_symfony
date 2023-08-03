<?php

namespace App\Form;

use App\Entity\StudyClass;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
	        ->add('study_class', EntityType::class, [
		        'class' => StudyClass::class,
		        'choices' => $options['study_classes'],
		        'choice_label' => 'number',
		        'multiple' => true,
		        'expanded' => true, // If you want to display checkboxes/radios
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
	        'study_classes' => StudyClass::class
        ]);
    }
}
