<?php

namespace DiabeteHelperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlycemieType extends AbstractType {
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('tauxGlycemie')->add('tauxAcetone')->add('dateGlycemie')->add(
      'repas'
    )->add('activite')->add('remarque')->add('iduser');
  }

  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(
      array(
        'data_class' => 'DiabeteHelperBundle\Entity\Glycemie',
      )
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockPrefix() {
    return 'diabetehelperbundle_glycemie';
  }


}
