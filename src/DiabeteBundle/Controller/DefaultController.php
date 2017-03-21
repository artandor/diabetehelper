<?php

namespace DiabeteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
  public function indexAction() {
    return $this->render('DiabeteBundle:defaults:index.html.twig');
  }
}
