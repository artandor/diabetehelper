<?php
/**
 * Copyright (c) 2016 - 2017.  Nicolas MYLLE
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 */

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
     * @var string
     */
    private $carbohydrate;
    /**
     * @var \DateTime
     */
    private $dateMeal;
    /**
     * @var string
     */
    private $estimatedMealBolus;

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
     * Get carbohydrates
     *
     * @return string
     */
    public function getCarbohydrates()
    {
        return $this->carbohydrates;
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
     * Get estimatedMealBolus
     *
     * @return string
     */
    public function getEstimatedMealBolus()
    {
        return $this->estimatedMealBolus;
    }

    /**
     * Set estimatedMealBolus
     *
     * @return Meal
     * @throws \Exception
     */
    public function setEstimatedMealBolus()
    {
        $user = $this->getIduser();

        $ratios = json_decode($user->getCarbsInsulinRatio());

        if ($ratios !== null) {
            $time = $this->getDateMeal()->format('H:i');
            /** @var array $ratios */
            foreach ($ratios as $key => $plage) {
                if ($time > $plage->hourstart && $time < $plage->hourend) {
                    $estimatedMealBolus = ($this->getCarbohydrate() * $plage->ratio) / 10;
                }
            }
            $this->estimatedMealBolus = $estimatedMealBolus;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(428, 'Carbs/Insulin Ratio');
        }
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
     * Get dateMeal
     *
     * @return \DateTime
     */
    public function getDateMeal()
    {
        return $this->dateMeal;
    }

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
     * Get carbohydrate
     *
     * @return string
     */
    public function getCarbohydrate()
    {
        return $this->carbohydrate;
    }

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
}
