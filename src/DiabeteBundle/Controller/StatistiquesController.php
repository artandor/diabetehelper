<?php

namespace DiabeteBundle\Controller;


use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatistiquesController extends Controller {
  public function indexAction() {
    //Listing des glycémies de l'utilisateur connecté
    $em = $this->getDoctrine()->getManager();
    $glycemies = $em->getRepository('DiabeteBundle:Glycemie')->findBy(
      array('iduser' => $this->getUser()->getId()),
      array('dateGlycemie' => 'DESC')
    );

    //Création d'une fourchette de dates
    $dateToday = "now";
    $twoWeeksAgo = "- 2 weeks";

    $dateDebut = new \DateTime($twoWeeksAgo);
    $dateDebut = $dateDebut->format('Y/M/d');
    $dateFin = new \DateTime($dateToday);
    $dateFin = $dateFin->format('Y/M/d');

    $dateBoucle = new \DateTime($twoWeeksAgo);


    $moyenne = array();

    //Création d'un tableau contenant la moyenne de toutes les glycémies de l'utilisateur connecté
    foreach ($glycemies as $key => $glycemie)//Parcours des glycémies
    {
      @$keyless = $key - 1;
      //Conditions sur la fourchette de date
      if ($glycemie->getDateGlycemie()->format(
          'Y/M/d'
        ) >= $dateDebut && $glycemie->getDateGlycemie()->format(
          'Y/M/d'
        ) <= $dateFin
      ) {
        //Si une date est identique à la date de la ligne précédente du tableau moyenne, on fait la moyenne des deux lignes et on supprime la précédente
        if ($glycemie->getDateGlycemie()->format(
            'Y/M/d'
          ) == @$moyenne[$keyless]['dateGlycemie']
        ) {
          $moyenne[$key]['coef'] = $moyenne[$keyless]['coef'] + 1;
          $moyenne[$key]['dateGlycemie'] = $glycemie->getDateGlycemie()->format(
            'Y/M/d'
          );
          $moyenne[$key]['tauxGlycemie'] = ($glycemie->getTauxGlycemie(
              ) + ($moyenne[$keyless]['tauxGlycemie'] * $moyenne[$keyless]['coef'])) / ($moyenne[$key]['coef']);
          unset($moyenne[$keyless]);
        }
        else //sinon on crée une nouvelle ligne
        {
          $moyenne[$key]['coef'] = 1;
          $moyenne[$key]['dateGlycemie'] = $glycemie->getDateGlycemie()->format(
            'Y/M/d'
          );
          $moyenne[$key]['tauxGlycemie'] = $glycemie->getTauxGlycemie();
        }
      }
    }

    /*
     * Mise en place du tableau qui va alimenter la courbe
     */
    $donneesCourbe = array(
      ['Date', 'Glycemie moyenne', 'Glucides ingérés'],
    );
    $test = NULL;

    foreach ($moyenne as $key => $m) {
      /*if (!in_array($dateBoucle->format('Y/M/d'), $moyenne[$key]))
      {
        $test = "Date non trouvée : " . $moyenne[$key]['dateGlycemie'];
      }*/

      $dateBoucle->modify('+1 day');
      $date = \DateTime::createFromFormat('Y/M/d', $m['dateGlycemie']);
      $date->format('d/M');
      $donneesCourbe[] = array(
        $date,
        floatval($m['tauxGlycemie']),
        rand(0, 140),
      );
    }


    $lineChart = new LineChart();
    $lineChart->getData()->setArrayToDataTable($donneesCourbe);

    $lineChart->getOptions()
      ->setTitle('Moyenne glycémique des 15 derniers jours')
      ->setWidth(1100)
      ->setHeight(500);
    $lineChart->getOptions()->setCurveType('function');

    $vAxisLeft = new VAxis();
    $vAxisLeft
      ->setTitle('Taux glycémie (g/L)')
      ->getViewWindow()->setMin(0.40);


    $vAxisRight = new VAxis();
    $vAxisRight
      ->setTitle('Glucides ingérés (g)')
      ->getViewWindow()->setMin(0);
    $vAxisRight->getGridlines()->setColor('transparent');


    $serieGlycemie = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\LineChart\Series(
    );
    $serieGlycemie->setTargetAxisIndex(0);
    $serieGlycemie->setColor('red');

    $serieRight = new \CMEN\GoogleChartsBundle\GoogleCharts\Options\LineChart\Series(
    );
    $serieRight->setTargetAxisIndex(1);
    $serieRight->setColor('lightblue');

    $lineChart->getOptions()->setVAxes(
      array(0 => $vAxisLeft, 1 => $vAxisRight)
    );

    $lineChart->getOptions()->setSeries(array($serieGlycemie, $serieRight));

    $lineChart->getOptions()
      ->getHAxis()
      ->setFormat('d/M')
      ->setTitle('Date')
      ->getGridlines()->setCount(15);

    $lineChart->getOptions()->setInterpolateNulls(FALSE);


    return $this->render(
      'DiabeteBundle:statistiques:index.html.twig',
      array(
        'glycemies' => $glycemies,
        'dateDebut' => $dateDebut,
        'dateFin' => $dateFin,
        'dateBoucle' => $dateBoucle,
        'moyenne' => $moyenne,
        'linechart' => $lineChart,
        'test' => $test,
      )
    );
  }
}

