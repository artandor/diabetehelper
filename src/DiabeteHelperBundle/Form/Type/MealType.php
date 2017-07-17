<?php

namespace DiabeteHelperBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MealType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add(
            'carbohydrate'
            )
        ->add(
            'dateMeal',
            DateTimeType::class,
            array(
              'label'=> 'date/hour of the Meal',
              'data' => new \DateTime('NOW'),
              'date_format' => 'd M y'
            )
          )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => 'DiabeteHelperBundle\Entity\Meal'
        )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'diabetehelperbundle_meal';
    }


}
