<?php

/**
 * Created by PhpStorm.
 * User: millt
 * Date: 18/07/2017
 * Time: 14:15
 */

namespace Tests\DiabeteHelperBundle\Util;

use PHPUnit\Framework\TestCase;
use DiabeteHelperBundle\Entity\Meal;
use DiabeteHelperBundle\Entity\User;

class MealTest extends TestCase {
    public function testSetEstimatedMealBolus() {
        $meal = new Meal();
        //Calculating bolus for a Meal with 90g of carbohydrates
        $meal->setCarbohydrate(90);
        //Create datetime object
        $dateTime = new \DateTime('NOW');
        //We will calculate bolus with the ratio of 18:00 -> 23:59, wich is 2.7U/10g of carbs.
        $dateTime->setTime(19,00);
        $meal->setDateMeal($dateTime);
        
        $user = new User();
        //Setting up ratios for the full day
        $user->setCarbsInsulinRatio('[{"hourend":"10:00","ratio":2.5,"hourstart":"00:00"},{"hourend":"15:00","ratio":1.7,"hourstart":"10:00"},{"hourend":"18:00","ratio":2.2,"hourstart":"15:00"},{"hourend":"23:59","ratio":2.7,"hourstart":"18:00"}]');
        
        $meal->setEstimatedMealBolus($user);
        
        $this->assertNotEquals(24.3, round($meal->getEstimatedMealBolus()));
    }
    
    public function testSetEstimatedMealBolusException() : void {
        //Testing the Exception response if no ratio are provided.
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        
        $meal = new Meal();
        
        $meal->setCarbohydrate(90);

        $dateTime = new \DateTime('NOW');
        $dateTime->setTime(19,00);
        $meal->setDateMeal($dateTime);
        
        $user = new User();
        
        $user->setCarbsInsulinRatio();
        
        $meal->setEstimatedMealBolus($user);
    }
}