<?php
/**
 * Created by PhpStorm.
 * User: millt
 * Date: 03/06/2017
 * Time: 18:17
 */

namespace Tests\DiabeteHelperBundle\Util;


use DiabeteHelperBundle\Entity\Glycemie;
use DiabeteHelperBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class GlycemieTest extends TestCase {
  public function testEstimatedCorrectionBolusTrue() {
    $glycemie = new Glycemie();
    $glycemie->setTauxGlycemie(2.00);
    $user = new User();
    $user->setInsulinSensivity(0.2);
    $user->setGlycemicObjective(1.20);
    $glycemie->setEstimatedCorrectionBolus($user);

    $this->assertEquals(4, $glycemie->getEstimatedCorrectionBolus());
  }

  public function testEstimatedCorrectionBolusFalse() {
    $glycemie = new Glycemie();
    $glycemie->setTauxGlycemie(2.00);
    $user = new User();
    $user->setInsulinSensivity(0.3);
    $user->setGlycemicObjective(1.20);
    $glycemie->setEstimatedCorrectionBolus($user);

    $this->assertNotEquals(4.00, $glycemie->getEstimatedCorrectionBolus());

    //$this->assertEquals(0,0);

  }
}