<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnswerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $survey = $options['survey'];
        $builder
            ->add('answerId',EntityType::class,[
                'class' => "AppBundle\Entity\Choice",
                'choices' => $survey->getChoices(),
               'expanded'=>true,


            ])
        ->add('save', SubmitType::class, [
            'label' => 'Vote'
        ]);


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Answer',
            'survey' => null,

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_answer';
    }


}

/* 'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->whereBy('u.username', 'ASC')*/
