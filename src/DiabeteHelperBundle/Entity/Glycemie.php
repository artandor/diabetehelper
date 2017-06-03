<?php

namespace DiabeteHelperBundle\Entity;

/**
 * Glycemie
 */

class Glycemie {
  /**
   * @var integer
   */
  private $idGlycemie;

  /**
   * @var string
   */
  private $tauxGlycemie;

  /**
   * @var string
   */
  private $tauxAcetone;

  /**
   * @var \DateTime
   */
  private $dateGlycemie;

  /**
   * @var string
   */
  private $repas;

  /**
   * @var string
   */
  private $activite;

  /**
   * @var string
   */
  private $remarque;

  /**
   * @var \DiabeteHelperBundle\Entity\User
   */
  private $iduser;
  /**
   * @var string
   */
  private $estimatedCorrectionBolus;

  /**
   * Get idGlycemie
   *
   * @return integer
   */
  public function getIdGlycemie() {
    return $this->idGlycemie;
  }

  /**
   * Get tauxAcetone
   *
   * @return string
   */
  public function getTauxAcetone() {
    return $this->tauxAcetone;
  }

  /**
   * Set tauxAcetone
   *
   * @param string $tauxAcetone
   *
   * @return Glycemie
   */
  public function setTauxAcetone($tauxAcetone) {
    $this->tauxAcetone = $tauxAcetone;

    return $this;
  }

  /**
   * Get dateGlycemie
   *
   * @return \DateTime
   */
  public function getDateGlycemie() {
    return $this->dateGlycemie;
  }

  /**
   * Set dateGlycemie
   *
   * @param \DateTime $dateGlycemie
   *
   * @return Glycemie
   */
  public function setDateGlycemie($dateGlycemie) {
    $this->dateGlycemie = $dateGlycemie;

    return $this;
  }

  /**
   * Get repas
   *
   * @return string
   */
  public function getRepas() {
    return $this->repas;
  }

  /**
   * Set repas
   *
   * @param string $repas
   *
   * @return Glycemie
   */
  public function setRepas($repas) {
    $this->repas = $repas;

    return $this;
  }

  /**
   * Get activite
   *
   * @return string
   */
  public function getActivite() {
    return $this->activite;
  }

  /**
   * Set activite
   *
   * @param string $activite
   *
   * @return Glycemie
   */
  public function setActivite($activite) {
    $this->activite = $activite;

    return $this;
  }

  /**
   * Get remarque
   *
   * @return string
   */
  public function getRemarque() {
    return $this->remarque;
  }

  /**
   * Set remarque
   *
   * @param string $remarque
   *
   * @return Glycemie
   */
  public function setRemarque($remarque) {
    $this->remarque = $remarque;

    return $this;
  }

  /**
   * Get estimatedCorrectionBolus
   *
   * @return string
   */
  public function getEstimatedCorrectionBolus() {
    return $this->estimatedCorrectionBolus;
  }

  /**
   * Set estimatedCorrectionBolus
   *
   * @param \DiabeteHelperBundle\Entity\User $user
   *
   * @return \DiabeteHelperBundle\Entity\Glycemie
   */
  public function setEstimatedCorrectionBolus(User $user = NULL) {
    if ($user == NULL) {
      $user = $this->getIduser();
    }
    if ($user->getGlycemicObjective() && $user->getInsulinSensivity()) {
      if ($this->getTauxGlycemie() - $user->getGlycemicObjective() >= 0) {
        $estimatedCorrectionBolus = ($this->getTauxGlycemie(
            ) - $user->getGlycemicObjective()) / $user->getInsulinSensivity();
      }
      else {
        $estimatedCorrectionBolus = 0;
      }
    }
    else {
      $estimatedCorrectionBolus = NULL;
    }
    $this->estimatedCorrectionBolus = $estimatedCorrectionBolus;

    return $this;
  }

  /**
   * Get iduser
   *
   * @return \DiabeteHelperBundle\Entity\User
   */
  public function getIduser() {
    return $this->iduser;
  }

  /**
   * Set iduser
   *
   * @param \DiabeteHelperBundle\Entity\User $iduser
   *
   * @return Glycemie
   */
  public function setIduser(User $iduser = NULL) {
    $this->iduser = $iduser;

    return $this;
  }

  /**
   * Get tauxGlycemie
   *
   * @return string
   */
  public function getTauxGlycemie() {
    return $this->tauxGlycemie;
  }

  /**
   * Set tauxGlycemie
   *
   * @param string $tauxGlycemie
   *
   * @return Glycemie
   */
  public function setTauxGlycemie($tauxGlycemie) {
    $this->tauxGlycemie = $tauxGlycemie;

    return $this;
  }
}
