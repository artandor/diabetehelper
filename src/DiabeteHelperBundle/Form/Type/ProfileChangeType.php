<?php
/**
 * Copyright (c) 2016 - 2017.  Nicolas MYLLE
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 */

namespace DiabeteHelperBundle\Form\Type;

use DiabeteHelperBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProfileChangeType
 * @package DiabeteHelperBundle\Form\Type
 */
class ProfileChangeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'weight',
                NumberType::class,
                array(
                    'label' => 'Your weight',
                    'required' => FALSE,
                )
            )
            ->add(
                'height',
                NumberType::class,
                array(
                    'label' => 'Your height',
                    'required' => FALSE,
                )
            )
            ->add(
                'yearofbirth',
                DateType::class,
                array(
                    'widget' => 'single_text',
                    'required' => FALSE,
                    'label' => 'The year of your birth',
                )
            )
            ->add(
                'bloodType',
                ChoiceType::class,
                array(
                    'label' => 'Your blood type',
                    'placeholder' => 'Choose your blood type',
                    'choices' => array(
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                        'O+' => 'O+',
                        'O-' => 'O-',
                    ),
                    'required' => FALSE,
                )
            )
            ->add('lastHb1c', NULL, array('label' => 'The % of your last hb1c'))
            ->add(
                'lastHb1cDate',
                DateType::class,
                array(
                    'widget' => 'single_text',
                    'label' => 'The date you did your last Hb1c'
                )
            )
            ->add(
                'typeDiabete',
                ChoiceType::class,
                array(
                    'label' => 'The type of diabete you have',
                    'placeholder' => 'Choose your diabete type',
                    'choices' => array(
                        'Type 1' => 1,
                        'Type 2' => 2,
                    ),
                )
            )
            ->add(
                'insulinSensivity',
                NumberType::class,
                array(
                    'label' => 'Your insulin sensivity',
                    'attr' => array('placeholder' => '1 unit of insulin correct ... g/L in my glycemy'),
                )
            )
            ->add(
                'glycemicObjective',
                NumberType::class,
                array(
                    'label' => 'Your glycemic objective',
                    'attr' => array('placeholder' => 'What blood sugar level do you want after correction. Example : 1.20 g/L'),
                )
            )
            ->add(
                'typeTraitement',
                TextType::class,
                array(
                    'label' => 'What traitements do you take',
                    'required' => false
                )
            )
            ->add(
                'glucidInsulinRatio',
                HiddenType::class,
                array(
                    'required' => false
                )
            )
            ;
/*
            ->add(
                'test',
                TimeType::class,
                array(
                    'mapped' => false
                )
            )*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}
