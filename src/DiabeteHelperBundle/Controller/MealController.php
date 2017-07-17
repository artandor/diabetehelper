<?php
/**
 * Copyright (c) 2016 - 2017.  Nicolas MYLLE
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 */

namespace DiabeteHelperBundle\Controller;

use DiabeteHelperBundle\Entity\Meal;
use DiabeteHelperBundle\Form\Type\MealType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Meal controller.
 *
 */
class MealController extends Controller
{
    /**
     * Lists all meal entities.
     *
     * @throws \LogicException
     */
    public function indexAction()
    {
        $meals = $this->getUser()
            ? $this->getDoctrine()->getManager()->getRepository('DiabeteHelperBundle:Meal')->findByIduser($this->getUser()->getId(), array('dateMeal' => 'DESC'))
            : [];

        return $this->render('@DiabeteHelper/meal/index.html.twig', array(
            'meals' => $meals,
        ));
    }

    /**
     * Creates a new meal entity.
     *
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted(
            'ROLE_USER',
            NULL,
            'You must be connected to access this page.'
        );

        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $meal->setIduser($this->getUser());
            $meal->setEstimatedMealBolus();
            $em->persist($meal);
            $em->flush();

            return $this->redirectToRoute('meal_show', array('id' => $meal->getId()));
        }

        return $this->render('@DiabeteHelper/meal/new.html.twig', array(
            'meal' => $meal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a meal entity.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \LogicException
     */
    public function showAction(Meal $meal)
    {
        $deleteForm = $this->createDeleteForm($meal);

        $this->denyAccessUnlessGranted(
            'ROLE_USER',
            NULL,
            'You must be connected to access this page.'
        );

        if (!$this->isGranted('edit', $meal)) {
            throw new NotFoundHttpException('Page not found');
        }

        return $this->render('@DiabeteHelper/meal/show.html.twig', array(
            'meal' => $meal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a meal entity.
     *
     * @param Meal $meal The meal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Meal $meal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('meal_delete', array('id' => $meal->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing meal entity.
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function editAction(Request $request, Meal $meal)
    {
        $this->denyAccessUnlessGranted(
            'ROLE_USER',
            NULL,
            'You must be connected to access this page.'
        );

        $deleteForm = $this->createDeleteForm($meal);
        $editForm = $this->createForm(MealType::class, $meal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meal_edit', array('id' => $meal->getId()));
        }

        return $this->render('@DiabeteHelper/meal/edit.html.twig', array(
            'meal' => $meal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a meal entity.
     *
     * @throws \LogicException
     */
    public function deleteAction(Request $request, Meal $meal)
    {
        $form = $this->createDeleteForm($meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($meal);
            $em->flush();
        }

        return $this->redirectToRoute('meal_index');
    }
}
