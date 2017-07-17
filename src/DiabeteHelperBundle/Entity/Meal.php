<?php

namespace DiabeteHelperBundle\Entity;

/**
 * Meal
 */
class Meal
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $carbohydrates;

    /**
     * @var \DiabeteHelperBundle\Entity\User
     */
    private $iduser;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Meal
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set carbohydrates
     *
     * @param string $carbohydrates
     *
     * @return Meal
     */
    public function setCarbohydrates($carbohydrates)
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    /**
     * Get carbohydrates
     *
     * @return string
     */
    public function getCarbohydrates()
    {
        return $this->carbohydrates;
    }

    /**
     * Set iduser
     *
     * @param \DiabeteHelperBundle\Entity\User $iduser
     *
     * @return Meal
     */
    public function setIduser(\DiabeteHelperBundle\Entity\User $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \DiabeteHelperBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }
    /**
     * @var string
     */
    private $carbohydrate;


    /**
     * Set carbohydrate
     *
     * @param string $carbohydrate
     *
     * @return Meal
     */
    public function setCarbohydrate($carbohydrate)
    {
        $this->carbohydrate = $carbohydrate;

        return $this;
    }

    /**
     * Get carbohydrate
     *
     * @return string
     */
    public function getCarbohydrate()
    {
        return $this->carbohydrate;
    }
    /**
     * @var \DateTime
     */
    private $dateMeal;


    /**
     * Set dateMeal
     *
     * @param \DateTime $dateMeal
     *
     * @return Meal
     */
    public function setDateMeal($dateMeal)
    {
        $this->dateMeal = $dateMeal;

        return $this;
    }

    /**
     * Get dateMeal
     *
     * @return \DateTime
     */
    public function getDateMeal()
    {
        return $this->dateMeal;
    }
}
