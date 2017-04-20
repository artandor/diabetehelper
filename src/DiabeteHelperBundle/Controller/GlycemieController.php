<?php

namespace DiabeteHelperBundle\Controller;

use DiabeteHelperBundle\Entity\Glycemie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Glycemie controller.
 *
 */
class GlycemieController extends Controller {
  /**
   * Lists all glycemie entities.
   *
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $glycemies = $em->getRepository('DiabeteHelperBundle:Glycemie')->findAll();

    return $this->render(
      '@DiabeteHelper/glycemie/index.html.twig',
      array(
        'glycemies' => $glycemies,
      )
    );
  }

  /**
   * Creates a new glycemie entity.
   *
   */
  public function newAction(Request $request) {
    $glycemie = new Glycemie();
    $form = $this->createForm(
      'DiabeteHelperBundle\Form\GlycemieType',
      $glycemie
    );
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($glycemie);
      $em->flush();

      return $this->redirectToRoute(
        'glycemie_show',
        array('idGlycemie' => $glycemie->getIdglycemie())
      );
    }

    return $this->render(
      '@DiabeteHelper/glycemie/new.html.twig',
      array(
        'glycemie' => $glycemie,
        'form' => $form->createView(),
      )
    );
  }

  /**
   * Finds and displays a glycemie entity.
   * @param \DiabeteHelperBundle\Entity\Glycemie $glycemie
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Glycemie $glycemie) {
    $deleteForm = $this->createDeleteForm($glycemie);

    return $this->render(
      '@DiabeteHelper/glycemie/show.html.twig',
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
          array('idGlycemie' => $glycemie->getIdglycemie())
        )
      )
      ->setMethod('DELETE')
      ->getForm();
  }

  /**
   * Displays a form to edit an existing glycemie entity.
   * @param \Symfony\Component\HttpFoundation\Request $request
   * @param \DiabeteHelperBundle\Entity\Glycemie $glycemie
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
   */
  public function editAction(Request $request, Glycemie $glycemie) {
    $deleteForm = $this->createDeleteForm($glycemie);
    $editForm = $this->createForm(
      'DiabeteHelperBundle\Form\GlycemieType',
      $glycemie
    );
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute(
        'glycemie_edit',
        array('idGlycemie' => $glycemie->getIdglycemie())
      );
    }

    return $this->render(
      '@DiabeteHelper/glycemie/edit.html.twig',
      array(
        'glycemie' => $glycemie,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
      )
    );
  }

  /**
   * Deletes a glycemie entity.
   * @param \Symfony\Component\HttpFoundation\Request $request
   * @param \DiabeteHelperBundle\Entity\Glycemie $glycemie
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function deleteAction(Request $request, Glycemie $glycemie) {
    $form = $this->createDeleteForm($glycemie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($glycemie);
      $em->flush();
    }

    return $this->redirectToRoute('glycemie_index');
  }
}
