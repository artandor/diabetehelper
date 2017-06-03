<?php
// src/AppBundle/Form/ProfileChangeType.php

namespace DiabeteHelperBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileChangeType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
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
      ->add('bloodType', NULL, array('label' => 'Your blood type'))
      ->add('lastHb1c', NULL, array('label' => 'The % of your last hb1c'))
      ->add(
        'lastHb1cDate',
        DateType::class,
        array('label' => 'The date you did your last Hb1c')
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
        'typeTraitement',
        NULL,
        array('label' => 'What traitements do you take')
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
          'label' => 'Your glycemic objective (Already existing glycemias won\'t be overwritten)',
          'attr' => array(
            'placeholder' => 'What blood sugar level do you want after correction. Example : 1.20 g/L',
          ),
        )
      );
  }


  public function getParent() {
    return 'FOS\UserBundle\Form\Type\ProfileFormType';
  }

  public function getBlockPrefix() {
    return 'app_user_profile';
  }
}