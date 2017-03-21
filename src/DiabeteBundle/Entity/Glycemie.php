<?php
/**
 * Created by PhpStorm.
 * User: millt
 * Date: 21/12/2016
 * Time: 00:58
 */

namespace DiabeteBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="glycemies")
 */
class Glycemie {


  /**
   * @var integer
   *
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */

  protected $idGlycemie;

  /**
   * @var double
   *
   * @ORM\Column(name="tauxGlycemie", type="double", nullable=false)
   */

  private $tauxGlycemie;

  /**
   * @var double
   *
   * @ORM\Column(name="tauxAcetone", type="double", nullable=true)
   */

  private $tauxAcetone;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="dateGlycemie", type="datetime", nullable=false)
   */

  private $dateGlycemie;

  /**
   * @var string
   *
   * @ORM\Column(name="repas", type="string", length=50, nullable=true)
   */

  private $repas;

  /**
   * @var string
   *
   * @ORM\Column(name="activite", type="string", length=50, nullable=true)
   */

  private $activite;


  /**
   * @var string
   *
   * @ORM\Column(name="remarque", type="string", length=500, nullable=true)
   */

  private $remarque;


  /**
   * @var integer
   *
   * @ORM\OneToOne(targetEntity="integer")
   * @ORM\JoinColumn(name="iduser", referencedColumnName="id")
   */

  private $iduser;

  /**
   * Glycemie constructor.
   */
  public function __construct() {
  }

  /**
   * @return mixed
   */
  public function getIduser() {
    return $this->iduser;
  }

  /**
   * @param mixed $iduser
   */
  public function setIduser($iduser) {
    $this->iduser = $iduser;
  }

  /**
   * @return int
   */
  public function getIdGlycemie() {
    return $this->idGlycemie;
  }

  /**
   * @param int $idGlycemie
   */
  public function setIdGlycemie($idGlycemie) {
    $this->idGlycemie = $idGlycemie;
  }

  /**
   * @return float
   */
  public function getTauxGlycemie() {
    return $this->tauxGlycemie;
  }

  /**
   * @param float $tauxGlycemie
   */
  public function setTauxGlycemie($tauxGlycemie) {
    $this->tauxGlycemie = $tauxGlycemie;
  }

  /**
   * @return float
   */
  public function getTauxAcetone() {
    return $this->tauxAcetone;
  }

  /**
   * @param float $tauxAcetone
   */
  public function setTauxAcetone($tauxAcetone) {
    $this->tauxAcetone = $tauxAcetone;
  }

  /**
   * @return \DateTime
   */
  public function getDateGlycemie() {
    return $this->dateGlycemie;
  }

  /**
   * @param \DateTime $dateGlycemie
   */
  public function setDateGlycemie($dateGlycemie) {
    $this->dateGlycemie = $dateGlycemie;
  }

  /**
   * @return string
   */
  public function getRepas() {
    return $this->repas;
  }

  /**
   * @param string $repas
   */
  public function setRepas($repas) {
    $this->repas = $repas;
  }

  /**
   * @return string
   */
  public function getActivite() {
    return $this->activite;
  }

  /**
   * @param string $activite
   */
  public function setActivite($activite) {
    $this->activite = $activite;
  }

  /**
   * @return string
   */
  public function getRemarque() {
    return $this->remarque;
  }

  /**
   * @param string $remarque
   */
  public function setRemarque($remarque) {
    $this->remarque = $remarque;
  }


}