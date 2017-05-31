<?php

namespace DiabeteHelperBundle\Controller;

use DiabeteHelperBundle\Entity\Glycemie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    ($this->getUser()) ? $glycemies = $em->getRepository(
      'DiabeteHelperBundle:Glycemie'
    )->findByIduser($this->getUser()->getId(), array('dateGlycemie' => 'DESC')) : NULL;


    $renderParams = array();
    isset($glycemies) ? $renderParams['glycemies'] = $glycemies : NULL;
    return $this->render(
      '@DiabeteHelper/glycemie/index.html.twig',
      $renderParams
    );
  }

  /**
   * Creates a new glycemie entity.
   *
   */
  public function newAction(Request $request) {
    $this->denyAccessUnlessGranted(
      'ROLE_USER',
      NULL,
      'You must be connected to access this page.'
    );
    //Permet de générer X glycémies contenant des glycémies entre 0.40 et 4.50, à des dates contenues dans les deux dernieres semaines
    //$this->genererGlycemies(200);

    $glycemie = new Glycemie();
    $form = $this->createForm(
      'DiabeteHelperBundle\Form\Type\GlycemieType',
      $glycemie
    );
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $glycemie->setIduser($this->getUser());
      $em->persist($glycemie);
      $em->flush();

      return $this->redirectToRoute(
        'glycemie_show',
        array('idGlycemie' => $glycemie->getIdGlycemie())
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
    $this->denyAccessUnlessGranted(
      'ROLE_USER',
      NULL,
      'You must be connected to access this page.'
    );

    if (!$this->isGranted('edit', $glycemie)) {
      throw new NotFoundHttpException("Page not found");
    }

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
          array('idGlycemie' => $glycemie->getIdGlycemie())
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
    $this->denyAccessUnlessGranted(
      'ROLE_USER',
      NULL,
      'You must be connected to access this page.'
    );

    $deleteForm = $this->createDeleteForm($glycemie);
    $editForm = $this->createForm(
      'DiabeteHelperBundle\Form\Type\GlycemieType',
      $glycemie
    );
    $editForm->handleRequest($request);

    if (!$this->isGranted('edit', $glycemie)) {
      throw new NotFoundHttpException("Page not found");
    }

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
