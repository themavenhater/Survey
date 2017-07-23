<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Survey;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

/**
 * Survey controller.
 *
 */
class SurveyController extends Controller
{
    /**
     * Lists all survey entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $surveys = $em->getRepository('AppBundle:Survey')->findAll();
        return $this->render('survey/index.html.twig', [
            'surveys' => $surveys,
        ]);
    }


    /**
     * Creates a new survey entity.
     */
    public function newAction(Request $request)
    {
        $survey = new Survey();

        $form = $this->createForm('AppBundle\Form\SurveyType', $survey);
        $form->handleRequest($request);
        $survey->setCreateDate(new \DateTime('NOW'));

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($survey->getChoices() as $choice){
                $choice->setSurvey($survey);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();

            return $this->redirectToRoute('survey_edit', ['id' => $survey->getId()]);
        }

        return $this->render('survey/new.html.twig', [
            'survey' => $survey,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Displays a form to edit an existing survey entity.
     *
     */
    public function editAction(Request $request, Survey $survey)
    {
        $deleteForm = $this->createDeleteForm($survey);
        $editForm = $this->createForm('AppBundle\Form\SurveyType', $survey);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('survey_edit', ['id' => $survey->getId()]);
        }

        return $this->render('survey/edit.html.twig', [
            'survey' => $survey,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a survey entity.
     *
     */
    public function deleteAction(Request $request, Survey $survey)
    {
        $form = $this->createDeleteForm($survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($survey);
            $em->flush();
        }

        return $this->redirectToRoute('survey_index');
    }

    /**
     * Creates a form to delete a survey entity.
     *
     * @param Survey $survey The survey entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Survey $survey)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('survey_delete', ['id' => $survey->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }




    /**
     * Show statistics
     */
    public function resultAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('AppBundle:Survey')->findOneBy([
            'id' => $id,
        ]);

        $result = $em->getRepository('AppBundle:Answer')->getSurveyAnswers($survey->getId());
        $count = $em->getRepository('AppBundle:Answer')->getAnswersNumber($survey->getId());

        /*var_dump($graph);
        die();*/
        return $this->render('survey/result.html.twig',[
            'survey' => $survey,
            'results' => $result,
            'count' => $count,
        ]);
    }

    public function statsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('AppBundle:Survey')->findOneBy([
            'id' => $id,
        ]);
        $result = $em->getRepository('AppBundle:Answer')->getSurveyAnswers($survey->getId());
        $days = $em->getRepository('AppBundle:Answer')->getDatesOneSurvey($survey->getId());
        $graph = $em->getRepository('AppBundle:Answer')->getAnswersByDate($survey->getId());
        return $this->render('survey/stats.html.twig',[
            'results' => $result,
            'graph' => $graph,
            'days' => $days,
            ]);
    }

    public function voteAction(Request $request,$zone=1)
    {
        $cookies = $request->cookies;


        $em = $this->getDoctrine()->getManager();
        $survey = $em->getRepository('AppBundle:Survey')->findOneBy([
            'status' => 1,
            'zone' => $zone,
        ]);


        $isVoted = $em->getRepository('AppBundle:Answer')->findOneBy([
            'ipAdress' => $request->getClientIp(),
            'session' => $request->getSession()->getId(),
            'lastSurvey' => $cookies->get('LastSurvey'),
        ]);

        if ($isVoted == null) {

            $answer = new Answer();
            $form = $this->createForm('AppBundle\Form\AnswerType', $answer, ['survey' => $survey]);
            $answer->setAnswerDate(new \DateTime('NOW'));
            $answer->setSession($request->getSession()->getId());
            $answer->setIpAdress($request->getClientIp());
            $answer->setLastSurvey($survey->getId());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($answer);
                $em->flush();

                $response = $this->redirectToRoute('survey_result',['id' => $survey->getId()]);
                $cookie = new Cookie('LastSurvey',$survey->getId(), strtotime('+ 1day'),'/');
                $response->headers->setCookie($cookie);
                return $response;
            }

            return $this->render('survey/vote.html.twig', [
                'survey' => $survey,
                'form' => $form->createView(),
            ]);
        } else {
            var_dump('tt');
                return $this->redirectToRoute('survey_result',['id' => $survey->getId()]);
        }
    }

}


