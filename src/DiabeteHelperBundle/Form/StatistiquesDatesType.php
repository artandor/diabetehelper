<?php

namespace DiabeteHelperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class StatistiquesDatesType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $translator = new Translator('fr', new MessageSelector());
    $builder
      ->add(
        'dateStart',
        DateTimeType::class,
        array(
          'label' => $translator->trans('Date start'),
          'data' => new \DateTime("-15 days"),
          'date_format' => 'd M y',
        )
      )
      ->add(
        'dateEnd',
        DateTimeType::class,
        array(
          'data' => new \DateTime("now"),
          'date_format' => 'd M y',
        )
      );
  }

  public function configureOptions(OptionsResolver $resolver) {

  }

  public function getName() {
    return 'diabete_helper_bundle_statistiques_dates_type';
  }
}
