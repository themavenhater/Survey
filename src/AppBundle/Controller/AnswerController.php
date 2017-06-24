<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Answer controller.
 *
 */
class AnswerController extends Controller
{
    /**
     * Lists all answer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $answers = $em->getRepository('AppBundle:Answer')->findAll();

        return $this->render('answer/index.html.twig', [
            'answers' => $answers,
        ]);
    }

    /**
     * Creates a new answer entity.
     *
     */
    public function newAction(Request $request)
    {

        $answer = new Answer();
        $form = $this->createForm('AppBundle\Form\AnswerType', $answer);
        $answer->setAnswerDate(new \DateTime('NOW'));
        $answer->setSession($request->getSession()->getId());
        $answer->setIpAdress($request->getClientIp());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('answer_show', ['id' => $answer->getId()]);
        }

        return $this->render('answer/new.html.twig', array(
            'answer' => $answer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a answer entity.
     *
     */
    public function showAction(Answer $answer)
    {
        $deleteForm = $this->createDeleteForm($answer);

        return $this->render('answer/show.html.twig', array(
            'answer' => $answer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

}
