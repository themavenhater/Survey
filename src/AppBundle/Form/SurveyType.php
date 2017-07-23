<?php

namespace AppBundle\Form;

use AppBundle\Entity\Survey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('startDate',DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
            ])

            ->add('endDate',DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
            ])

            ->add('title')

            ->add('description')

            ->add('type',ChoiceType::class, [
                'choices'  => [
                    'One answer' => 1,
                    'Multi Answers' => 2,
                ],])

            ->add('zone',ChoiceType::class, [
                'choices'  => [
                    'Public' => 1,
                    'Only Users' => 2,
                ],])

            ->add('choices', CollectionType::class,[
                'entry_type' => \AppBundle\Form\ChoiceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => [
                    'class' => 'my-selector',
                ],
                ])

            ->add('submit',SubmitType::class);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_survey';
    }


}

