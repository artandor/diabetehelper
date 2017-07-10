<?php

namespace DiabeteHelperBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

class GlycemieType extends AbstractType {
    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\Translation\Exception\InvalidArgumentException
     */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $translator = new Translator('fr', new MessageSelector());
    $builder->add(
      'tauxGlycemie',
      NumberType::class,
      array(
        'label'=> ucfirst($translator->trans('blood sugar level')),
        'attr' => array(
          'placeholder' => ucfirst($translator->trans('your blood sugar level in g/L (i.e. : 1.15 g/L)')),
        ),
        'required' => TRUE,
      )
    )
      ->add(
        'tauxAcetone',
        NumberType::class,
        array(
          'label'=> ucfirst($translator->trans('acetone level')),
          'attr' => array(
            'placeholder' => '0.0',
          ),
          'required' => FALSE,
        )
      )
      ->add(
        'dateGlycemie',
        NULL,
        array(
          'label'=> ucfirst($translator->trans('date/hour of')).' '. $translator->trans('the blood sugar test'),
          'data' => new \DateTime('NOW'),
          'date_format' => 'd M y',
        )
      )
      ->add(
        'repas',
        ChoiceType::class,
        array(
          'label'=> ucfirst($translator->trans('meal')),
          'choices' => array(
            ucfirst($translator->trans('blood sugar level done before meal')) => 'prePrandial',
            ucfirst($translator->trans('blood sugar level done after meal')) => 'postPrandial',
            ucfirst($translator->trans('on an empty stomach')) => "aJeun",
          ),
          'placeholder' => ucfirst($translator->trans('when did you do the blood sugar test ?')),
          'required' => FALSE,
        )
      )
      ->add(
        'activite',
        ChoiceType::class,
        array(
          'choices' => array(
            ucfirst($translator->trans('light activity (walk, ...)')) => ucfirst($translator->trans('light')),
            ucfirst($translator->trans('medium activity (fast walk, easy sport, ...')) => ucfirst($translator->trans('medium')),
            ucfirst($translator->trans('heavy activity (musculation, run, ...)')) => ucfirst($translator->trans('heavy')),
          ),
          'label'=> ucfirst($translator->trans('physical activity')),
          'expanded' => TRUE,
          'multiple' => FALSE,
          'placeholder' => ucfirst($translator->trans('no activity')),
          'required' => FALSE,
        )
      )
      ->add(
        'remarque',
        TextareaType::class,
        array(
          'label'=> ucfirst($translator->trans('note')),
          'required' => FALSE,
        )
      );
  }

    /**
     * {@inheritdoc}
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
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
