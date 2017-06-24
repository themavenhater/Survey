<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Choice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ChoiceController extends Controller
{
    /**
     * Lists all choice entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $choices = $em->getRepository('AppBundle:Choice')->findAll();

        return $this->render('choice/index.html.twig', [
            'choices' => $choices,
        ]);
    }

    /**
     * Creates a new choice entity.
     *
     */
    public function newAction(Request $request)
    {
        $choice = new Choice();
        $form = $this->createForm('AppBundle\Form\ChoiceType', $choice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($choice);
            $em->flush();

            return $this->redirectToRoute('choice_show', ['id' => $choice->getId()]);
        }

        return $this->render('choice/new.html.twig', [
            'choice' => $choice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a choice entity.
     *
     */
    public function showAction(Choice $choice)
    {
        $deleteForm = $this->createDeleteForm($choice);

        return $this->render('choice/show.html.twig', [
            'choice' => $choice,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing choice entity.
     *
     */
    public function editAction(Request $request, Choice $choice)
    {
        $deleteForm = $this->createDeleteForm($choice);
        $editForm = $this->createForm('AppBundle\Form\ChoiceType', $choice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('choice_edit', ['id' => $choice->getId()]);
        }

        return $this->render('choice/edit.html.twig', [
            'choice' => $choice,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a choice entity.
     *
     */
    public function deleteAction(Request $request, Choice $choice)
    {
        $form = $this->createDeleteForm($choice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($choice);
            $em->flush();
        }

        return $this->redirectToRoute('choice_index');
    }

    /**
     * Creates a form to delete a choice entity.
     *
     * @param Choice $choice The choice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Choice $choice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('choice_delete', ['id' => $choice->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
