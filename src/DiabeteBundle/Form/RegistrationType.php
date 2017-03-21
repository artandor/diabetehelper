<?php
// src/AppBundle/Form/RegistrationType.php

namespace DiabeteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('weight', NULL, array('label' => 'Your weight'))
      ->add('height', NULL, array('label' => 'Your height'))
      ->add(
        'yearofbirth',
        NULL,
        array(
          'label' => 'The year of your birth',
        )
      )
      ->add(
        'bloodType',
        ChoiceType::class,
        array(
          'label' => 'Your blood type',
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
        )
      )
      ->add('lastHb1c', NULL, array('label' => 'The % of your last hb1c'))
      ->add(
        'lastHb1cDate',
        NULL,
        array('label' => 'The date you did your last Hb1c')
      )
      ->add(
        'typeDiabete',
        ChoiceType::class,
        array(
          'label' => 'The type of diabete you have',
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
      );
  }

  public function getParent() {
    return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }

  public function getBlockPrefix() {
    return 'app_user_registration';
  }
}