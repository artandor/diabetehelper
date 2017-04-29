<?php
/**
 * Created by PhpStorm.
 * User: millt
 * Date: 29/04/2017
 * Time: 23:51
 */

namespace DiabeteHelperBundle\Security;


use DiabeteHelperBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

use DiabeteHelperBundle\Entity\Glycemie;

class GlycemieVoter extends Voter {
  // these strings are just invented: you can use anything
  const VIEW = 'view';
  const EDIT = 'edit';

  protected function supports($attribute, $subject) {
    // if the attribute isn't one we support, return false
    if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
      return FALSE;
    }

    // only vote on Glycemie objects inside this voter
    if (!$subject instanceof Glycemie) {
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

    // you know $subject is a Glycemie object, thanks to supports
    /** @var Glycemie $glycemie */
    $glycemie = $subject;

    switch ($attribute) {
      case self::VIEW:
        return $this->canView($glycemie, $user);
      case self::EDIT:
        return $this->canEdit($glycemie, $user);
    }

    throw new \LogicException('This code should not be reached!');
  }

  private function canView(Glycemie $glycemie, User $user) {
    // if they can edit, they can view
    if ($this->canEdit($glycemie, $user)) {
      return TRUE;
    }

    // the Glycemy object could have, for example, a method isPrivate()
    // that checks a boolean $private property
    return !$glycemie->isPrivate();
  }

  private function canEdit(Glycemie $glycemie, User $user) {
    // this assumes that the data object has a getId() method
    // to get the entity of the user who owns this data object
    return $user === $glycemie->getIduser();
  }
}