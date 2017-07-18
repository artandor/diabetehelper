<?php
namespace DiabeteHelperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser {
  /**
   * @var integer
   *
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var double
   *
   * @ORM\Column(name="weight", type="double", nullable=true)
   */
  private $weight;

  /**
   * @var double
   *
   * @ORM\Column(name="height", type="double", nullable=true)
   */
  private $height;


  /**
   * @var \DateTime
   *
   * @ORM\Column(name="yearOfBirth", type="int", nullable=true)
   */
  private $yearofbirth = NULL;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="bloodType", type="string", length=10, nullable=true)
   */
  private $bloodType;

  /**
   * @var double
   *
   * @ORM\Column(name="lastHb1c", type="double", nullable=true)
   */
  private $lastHb1c;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="lastHb1cDate", type="datetime", nullable=true)
   */
  private $lastHb1cDate;


  /**
   * @var string
   *
   * @ORM\Column(name="typeDiabete", type="string", length=20, nullable=true)
   */
  private $typeDiabete;


  /**
   * @var string
   *
   * @ORM\Column(name="typeTraitement", type="string", length=255, nullable=true)
   */
  private $typeTraitement;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="dateInscription", type="datetime", nullable=true)
   */
  private $dateInscription;
  /**
   * @var string
   */
  private $insulinSensivity;
  /**
   * @var string
   */
  private $glycemicObjective;

  public function __construct() {
    parent::__construct();
  }

  /**
   * @return float
   */
  public function getWeight() {
    return $this->weight;
  }

  /**
   * @param float $weight
   */
  public function setWeight($weight) {
    $this->weight = $weight;
  }

  /**
   * @return float
   */
  public function getHeight() {
    return $this->height;
  }

  /**
   * @param float $height
   */
  public function setHeight($height) {
    $this->height = $height;
  }

  /**
   * @return \DateTime
   */
  public function getYearOfBirth() {
    return $this->yearofbirth;
  }

  /**
   * @param \DateTime $yearofbirth
   */
  public function setYearOfBirth($yearofbirth) {
    $this->yearofbirth = $yearofbirth;
  }

  /**
   * @return string
   */
  public function getBloodType() {
    return $this->bloodType;
  }

  /**
   * @param string $bloodType
   */
  public function setBloodType($bloodType) {
    $this->bloodType = $bloodType;
  }

  /**
   * @return float
   */
  public function getLastHb1c() {
    return $this->lastHb1c;
  }

  /**
   * @param float $lastHb1c
   */
  public function setLastHb1c($lastHb1c) {
    $this->lastHb1c = $lastHb1c;
  }

  /**
   * @return \DateTime
   */
  public function getLastHb1cDate() {
    return $this->lastHb1cDate;
  }

  /**
   * @param \DateTime $lastHb1cDate
   */
  public function setLastHb1cDate($lastHb1cDate) {
    $this->lastHb1cDate = $lastHb1cDate;
  }

  /**
   * @return string
   */
  public function getTypeDiabete() {
    return $this->typeDiabete;
  }

  /**
   * @param string $typeDiabete
   */
  public function setTypeDiabete($typeDiabete) {
    $this->typeDiabete = $typeDiabete;
  }

  /**
   * @return string
   */
  public function getTypeTraitement() {
    return $this->typeTraitement;
  }

  /**
   * @param string $typeTraitement
   */
  public function setTypeTraitement($typeTraitement) {
    $this->typeTraitement = $typeTraitement;
  }

  /**
   * @return \DateTime
   */
  public function getDateInscription() {
    return $this->dateInscription;
  }

  /**
   * @param \DateTime $dateInscription
   */
  public function setDateInscription($dateInscription) {
    $this->dateInscription = $dateInscription;
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get insulinSensivity
   *
   * @return string
   */
  public function getInsulinSensivity() {
    return $this->insulinSensivity;
  }

  /**
   * Set insulinSensivity
   *
   * @param string $insulinSensivity
   *
   * @return User
   */
  public function setInsulinSensivity($insulinSensivity) {
    $this->insulinSensivity = $insulinSensivity;

    return $this;
  }

  /**
   * Get glycemicObjective
   *
   * @return string
   */
  public function getGlycemicObjective() {
    return $this->glycemicObjective;
  }

  /**
   * Set glycemicObjective
   *
   * @param string $glycemicObjective
   *
   * @return User
   */
  public function setGlycemicObjective($glycemicObjective) {
    $this->glycemicObjective = $glycemicObjective;

    return $this;
  }
    /**
     * @var string
     */
    private $glucidInsulinRatio;

    /**
     * Set carbsInsulinRatio
     *
     * @param string $carbsInsulinRatio
     *
     * @return User
     */
    public function setCarbsInsulinRatio($carbsInsulinRatio = null)
    {
        $this->carbsInsulinRatio = $carbsInsulinRatio;

        return $this;
    }

    /**
     * Get carbsInsulinRatio
     *
     * @return string
     */
    public function getCarbsInsulinRatio()
    {
        return $this->carbsInsulinRatio;
    }
}
