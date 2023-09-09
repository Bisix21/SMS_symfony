<?php

namespace App\Form;

use App\Entity\StudyClass;
use App\Entity\Subject;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
				'label'=>'Enter subject name:'
            ])
            ->add('description',TextType::class, [
	            'label'=>'Enter subject description:'
            ])
	        ->add('study_class', EntityType::class, [
		        'class' => StudyClass::class,
		        'choices' => $options['study_classes'],
		        'choice_label' => 'number',
		        'multiple' => true,
		        'expanded' => true,
            ])
	        ->add('active', CheckboxType::class,[
				'label'=>'Is active',
		        'required' => false
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
