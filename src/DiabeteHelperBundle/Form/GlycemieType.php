<?php

namespace DiabeteHelperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlycemieType extends AbstractType {
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add(
      'tauxGlycemie',
      NumberType::class,
      array(
        'attr' => array(
          'placeholder' => 'Your blood sugar level in g/L (i.e. : 1.15 g/L)',
        ),
        'required' => TRUE,
      )
    )
      ->add(
        'tauxAcetone',
        NumberType::class,
        array(
          'attr' => array(
            'placeholder' => 'Votre taux d\'acétone',
          ),
          'required' => FALSE,
        )
      )
      ->add(
        'dateGlycemie',
        NULL,
        array(
          'data' => new \DateTime("NOW"),
          'date_format' => 'd M y',
        )
      )
      ->add(
        'repas',
        ChoiceType::class,
        array(
          'choices' => array(
            'Glycemie faite avant le repas' => 'préPrandial',
            'Glycémie faite après le repas' => 'postPrandial',
            'Glycémie à jeûn' => "aJeun",
          ),
          'placeholder' => 'A quel moment avez vous fait la glycémie ?',
          'required' => FALSE,
        )
      )
      ->add(
        'activite',
        ChoiceType::class,
        array(
          'choices' => array(
            'Activité légère (marche calme, ...)' => 'faible',
            'Activité moyenne (marche rapide, sport, ...)' => 'moyenne',
            'Activité forte (musculation, course, ...)' => 'forte',
          ),
          'label' => "Activité physique",
          'expanded' => TRUE,
          'multiple' => FALSE,
          'placeholder' => 'Pas d\'activité',
          'required' => FALSE,
        )
      )
      ->add(
        'remarque',
        TextareaType::class,
        array(
          'required' => FALSE,
        )
      );
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
