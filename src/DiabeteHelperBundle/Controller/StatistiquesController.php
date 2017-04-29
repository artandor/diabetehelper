<?php

namespace DiabeteHelperBundle\Controller;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;

class StatistiquesController extends Controller {
  public function indexAction(Request $request) {
    $renderParams = array();
    $form = $this->createForm(
      'DiabeteHelperBundle\Form\StatistiquesDatesType'
    );
    $form->handleRequest($request);


    if ($request->request->get('statistiques_dates')){
      $datesForm = $request->request->get('statistiques_dates');

      $dateStartString = $datesForm['dateStart']['date']['year']. "/" . $datesForm['dateStart']['date']['month']. "/" . $datesForm['dateStart']['date']['day'];
      $dateStart = \DateTime::createFromFormat('Y/m/d', $dateStartString);
      $dateEndString = $datesForm['dateEnd']['date']['year']. "/" . $datesForm['dateEnd']['date']['month']. "/" . $datesForm['dateEnd']['date']['day'];
      $dateEnd = \DateTime::createFromFormat('Y/m/d', $dateEndString);
    }
    else{
      $dateStart = new \DateTime('- 15 days');
      $dateEnd = new \DateTime('now');
    }

    //Listing des glycémies de l'utilisateur connecté dans la fourchette de dates
    if ($this->getUser()){
      $em = $this->getDoctrine()->getManager();
      $glycemies = $em->getRepository('DiabeteHelperBundle:Glycemie')
        ->findGlycemiesByDates($dateStart, $dateEnd, $this->getUser()->getId());
    }
    else $glycemies = NULL;

    if (!empty($glycemies)){
      $donneesCourbe = $this->buildDatesArrayChart($dateStart, $dateEnd);

      $this->calculMoyennesGlycemiques($glycemies, $donneesCourbe);

      $lineChart = $this->createLineChart($donneesCourbe, $dateStart, $dateEnd);
    }

    $renderParams['form'] = $form->createView();
    $renderParams['glycemies'] = $glycemies;
    if(isset($lineChart)){$renderParams['linechart'] = $lineChart;};
    return $this->render(
      'DiabeteHelperBundle:statistiques:index.html.twig', $renderParams);
  }

  private function buildDatesArrayChart($dateStart, $dateEnd) {
    $data = array(
      [
        'Date',
        'Glycemie moyenne',
        //'Glucides ingérés'
      ],
    );
    $diff = $dateEnd->diff($dateStart)->d;
    $stockDateStart = clone $dateStart;
    //dump($diff);
    for ($i = 0; $i < $diff; $i++) {
      //dump($dateStart->modify('+ '. $i .' day'));
      $data[$stockDateStart->modify('+1 day')->format('d/M')] = array(
        $stockDateStart->format('d/M'),
        NULL,
        //rand(0, 140),
      );
    }
    return $data;
  }

  private function calculMoyennesGlycemiques($glycemies, &$destinationDatas) {
    $moyennes = array();
    foreach ($glycemies as $key => $glycemie) {

      if (!array_key_exists(
        $glycemie->getDateGlycemie()->format('d/M'),
        $moyennes
      )
      ) {
        $moyennes[$glycemie->getDateGlycemie()->format(
          'd/M'
        )]['dateGlycemie'] = $glycemie->getDateGlycemie()->format('d/M');
        $moyennes[$glycemie->getDateGlycemie()->format(
          'd/M'
        )]['tauxGlycemie'] = $glycemie->getTauxGlycemie();
        $moyennes[$glycemie->getDateGlycemie()->format('d/M')]['coef'] = 1;
      }
      else {
        $moyennes[$glycemie->getDateGlycemie()->format('d/M')]['tauxGlycemie'] =
          (
            (
              $moyennes[$glycemie->getDateGlycemie()->format(
                'd/M'
              )]['tauxGlycemie']
              *
              $moyennes[$glycemie->getDateGlycemie()->format('d/M')]['coef']
            ) + $glycemie->getTauxGlycemie()
          )
          /
          ($moyennes[$glycemie->getDateGlycemie()->format('d/M')]['coef'] + 1);

        $moyennes[$glycemie->getDateGlycemie()->format('d/M')]['coef']++;
      }
    }
    //dump($moyennes);
    foreach ($moyennes as $key2 => $taux) {
      //dump($taux);
      $destinationDatas[$taux['dateGlycemie']][1] = floatval($taux['tauxGlycemie']);
    }
  }

  private function createLineChart($donneesCourbe, $dateStart, $dateEnd){
    $translator = new Translator('fr', new MessageSelector());
    $lineChart = new LineChart();
    $lineChart->getData()->setArrayToDataTable($donneesCourbe);

    $lineChart->getOptions()
      ->setTitle(ucfirst($translator->trans('glycemic mean curve from')).' '. $dateStart->format('d/M/Y') .' to '. $dateEnd->format('d/M/Y'))
      ->setWidth(1100)
      ->setHeight(500);
    $lineChart->getOptions()->setCurveType('function');

    $vAxisLeft = new VAxis();
    $vAxisLeft
      ->setTitle(ucfirst($translator->trans('blood sugar level')).' (g/L)')
      ->getViewWindow()->setMin(0.40);


    /*$vAxisRight = new VAxis();
    $vAxisRight
      ->setTitle('Glucides ingérés (g)')
      ->getViewWindow()->setMin(0);
    $vAxisRight->getGridlines()->setColor('transparent');*/


    $serieGlycemie = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\LineChart\Series();
    $serieGlycemie->setTargetAxisIndex(0);
    $serieGlycemie->setColor('red');

    /*$serieRight = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\LineChart\Series(
    );
    $serieRight->setTargetAxisIndex(1);
    $serieRight->setColor('lightblue');*/

    $lineChart->getOptions()->setVAxes(
      array(
        0 => $vAxisLeft,
        //1 => $vAxisRight
      )
    );

    $lineChart->getOptions()->setSeries(
      array(
        $serieGlycemie,
        //$serieRight
      )
    );

    $lineChart->getOptions()
      ->getHAxis()
      ->setFormat('d/M')
      ->setTitle(ucfirst($translator->trans('Date')))
      ->getGridlines()->setCount(15);

    $lineChart->getOptions()->setInterpolateNulls(FALSE);
    return $lineChart;
  }
}