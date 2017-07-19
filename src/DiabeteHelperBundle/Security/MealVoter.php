<?php
/**
 * Created by PhpStorm.
 * User: millt
 * Date: 17/07/2017
 * Time: 16:00
 */

namespace DiabeteHelperBundle\Security;


use DiabeteHelperBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use DiabeteHelperBundle\Entity\Meal;

class MealVoter extends Voter {
  // these strings are just invented: you can use anything
  const VIEW = 'view';
  const EDIT = 'edit';

  protected function supports($attribute, $subject) {
    // if the attribute isn't one we support, return false
    if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
      return FALSE;
    }

    // only vote on Meal objects inside this voter
    if (!$subject instanceof Meal) {
      return FALSE;
    }

    return TRUE;
  }

  protected function voteOnAttribute(
    $attribute,
    $subject,
    TokenInterface $token
  ) {
    $user = $token->getUser();

    if (!$user instanceof User) {
      // the user must be logged in; if not, deny access
      return FALSE;
    }

    // you know $subject is a Meal object, thanks to supports
    /** @var Meal $meal */
    $meal = $subject;

    switch ($attribute) {
      case self::VIEW:
        return $this->canView($meal, $user);
      case self::EDIT:
        return $this->canEdit($meal, $user);
    }

    throw new \LogicException('This code should not be reached!');
  }

  private function canView(Meal $meal, User $user) {
    // if they can edit, they can view
    if ($this->canEdit($meal, $user)) {
      return TRUE;
    }

    // the Glycemy object could have, for example, a method isPrivate()
    // that checks a boolean $private property
    //return !$meal->isPrivate();
  }

  private function canEdit(Meal $meal, User $user) {
    // this assumes that the data object has a getId() method
    // to get the entity of the user who owns this data object
    return $user === $meal->getIduser();
  }
}
