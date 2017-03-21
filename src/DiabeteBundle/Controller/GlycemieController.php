<?php

namespace DiabeteBundle\Controller;

use DiabeteBundle\Entity\Glycemie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

/**
 * Glycemie controller.
 *
 * @Route("glycemie")
 */
class GlycemieController extends Controller {
  /**
   * Lists all glycemie entities.
   *
   * @Route("/", name="glycemie_index")
   * @Method("GET")
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $glycemies = $em->getRepository('DiabeteBundle:Glycemie')->findBy(
      array('iduser' => $this->getUser()),
      array('dateGlycemie' => 'DESC')
    );

    return $this->render(
      'DiabeteBundle:glycemie:index.html.twig',
      array(
        'glycemies' => $glycemies,
      )
    );
  }

  /**
   * Creates a new glycemie entity.
   *
   * @Route("/new", name="glycemie_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request) {

    //Permet de générer X glycémies contenant des glycémies entre 0.40 et 4.50, à des dates contenues dans les deux dernieres semaines
    //$this->genererGlycemies(200);

    $glycemie = new Glycemie();
    $form = $this->createForm('DiabeteBundle\Form\GlycemieType', $glycemie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $glycemie->setIduser($this->getUser());
      $em->persist($glycemie);
      $em->flush($glycemie);

      return $this->redirectToRoute(
        'glycemie_show',
        array('id' => $glycemie->getIdGlycemie())
      );
    }

    return $this->render(
      'DiabeteBundle:glycemie:new.html.twig',
      array(
        'glycemie' => $glycemie,
        'form' => $form->createView(),
      )
    );
  }

  /**
   * Finds and displays a glycemie entity.
   *
   * @Route("/{id}", name="glycemie_show")
   * @Method("GET")
   */
  public function showAction(Glycemie $glycemie) {
    $deleteForm = $this->createDeleteForm($glycemie);

    return $this->render(
      'DiabeteBundle:glycemie:show.html.twig',
      array(
        'glycemie' => $glycemie,
        'delete_form' => $deleteForm->createView(),
      )
    );
  }

  /**
   * Creates a form to delete a glycemie entity.
   *
   * @param Glycemie $glycemie The glycemie entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Glycemie $glycemie) {
    return $this->createFormBuilder()
      ->setAction(
        $this->generateUrl(
          'glycemie_delete',
          array('id' => $glycemie->getIdGlycemie())
        )
      )
      ->setMethod('DELETE')
      ->getForm();
  }

  /**
   * Displays a form to edit an existing glycemie entity.
   *
   * @Route("/{id}/edit", name="glycemie_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Glycemie $glycemie) {
    $deleteForm = $this->createDeleteForm($glycemie);
    $editForm = $this->createForm('DiabeteBundle\Form\GlycemieType', $glycemie);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute(
        'glycemie_edit',
        array('id' => $glycemie->getIdGlycemie())
      );
    }

    return $this->render(
      'DiabeteBundle:glycemie:edit.html.twig',
      array(
        'glycemie' => $glycemie,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
      )
    );
  }

  /**
   * Deletes a glycemie entity.
   *
   * @Route("/{id}", name="glycemie_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Glycemie $glycemie) {
    $form = $this->createDeleteForm($glycemie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($glycemie);
      $em->flush($glycemie);
    }

    return $this->redirectToRoute('glycemie_index');
  }


  /*
   * Peuplement des glycémies
   */

  private function genererGlycemies($quantite) {

    $randomGlycemy = rand(40, 450) / 100;
    $generatedGlycemy = new Glycemie();
    $generatedGlycemy->setIduser($this->getUser());
    $generatedGlycemy->setDateGlycemie(new \DateTime("now"));
    $generatedGlycemy->setTauxGlycemie($randomGlycemy);

    $em = $this->getDoctrine()->getManager();
    $em->persist($generatedGlycemy);
    $em->flush($generatedGlycemy);

    for ($i = 1; $i <= $quantite; $i++) {
      $randomGlycemy = rand(40, 450) / 100;
      $randomDate = rand(1, 15);
      $randomDate = '-' . $randomDate . ' day';
      $generatedGlycemy = new Glycemie();
      $generatedGlycemy->setIduser($this->getUser());
      $generatedGlycemy->setDateGlycemie(new \DateTime($randomDate));
      $generatedGlycemy->setTauxGlycemie($randomGlycemy);

      $em = $this->getDoctrine()->getManager();
      $em->persist($generatedGlycemy);
      $em->flush($generatedGlycemy);
    }


  }

}



