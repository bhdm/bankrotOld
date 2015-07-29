<?php

namespace Bankrot\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Bankrot\SiteBundle\Entity\ForumTheme;
use Bankrot\SiteBundle\Entity\ForumQuestion;
use Bankrot\SiteBundle\Entity\ForumAnswer;
use Bankrot\SiteBundle\Form\ForumThemeType;
use Bankrot\SiteBundle\Form\ForumQuestionType;
use Bankrot\SiteBundle\Form\ForumAnswerType;

/**
 * Class ForumController
 * @package BankrotSiteBundle\Controller
 * @Security("has_role('ROLE_USER')")
 * @Route("/forum")
 *
 */
class ForumController extends Controller
{
    /**
     * Главная страница форума
     * @Route("/", name="forum_index")
     * @Template()
     */
    public function indexAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $item = new ForumTheme();
        $form = $this->createForm(new ForumThemeType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('forum_index'));
            }
        }
        $themes = $em->getRepository('BankrotSiteBundle:ForumTheme')->findBy(array('enabled'=> true), array('id' => 'DESC'));
        return array(
            'themes' => $themes,
            'form' => $form->createView()
        );
    }

    /**
     * Список вопросов выбранной темы
     * @Route("/questions/{themeId}", name="forum_questions")
     * @Template()
     */
    public function questionsAction(Request $request, $themeId){
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('BankrotSiteBundle:ForumTheme')->find($themeId);

        if ($theme == null){
            throw $this->createNotFoundException('');
        }

        $questions = $this->getDoctrine()->getRepository('BankrotSiteBundle:ForumQuestion')->findBy(array('enabled'=>true, 'theme'=>$theme), array('id' => 'DESC'));


        $item = new ForumQuestion();
        $form = $this->createForm(new ForumQuestionType($em), $item);
        $formData = $form->handleRequest($request);
        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setTheme($theme);
                $item->setAuthor($this->getUser());
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('forum_questions', array('themeId' =>$themeId)));
            }
        }

        return array(
            'questions' => $questions,
            'theme' => $theme,
            'form' => $form->createView()
        );
    }

    /**
     * Список ответов определенного вопроса определенной темы
     * @Route("/answers/{themeId}/{questionId}", name="forum_answers")
     * @Template()
     */
    public function answersAction(Request $request, $themeId, $questionId){
        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('BankrotSiteBundle:ForumTheme')->find($themeId);
        $question = $em->getRepository('BankrotSiteBundle:ForumQuestion')->find($questionId);
//        $answers = $em->getRepository('BlogBundle:ForumAnswer')->findBy(array('enabled'=>true, 'question'=>$question));

        if ($theme == null || $question == null){
            throw $this->createNotFoundException('');
        }


        $item = new ForumAnswer();
        $form = $this->createForm(new ForumAnswerType($em), $item);
        $formData = $form->handleRequest($request);
        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $item->setTheme($theme);
                $item->setAuthor($this->getUser());
                $item->setQuestion($question);
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('forum_answers', array('themeId' =>$themeId, 'questionId' => $questionId)));
            }

        }
        $answers = $em->getRepository('BankrotSiteBundle:ForumAnswer')->findBy(array('enabled'=>true, 'question'=>$question));

        return array(
            'answers' => $answers,
            'question' => $question,
            'theme' => $theme,
            'form' => $form->createView()
        );
    }

    /**
     * Удаление ответа
     * @Route("answers/delete/{answerId}", name="answers-delete")
     */
    public function answerDeleteAction(Request $request, $answerId){
        $em = $this->getDoctrine()->getManager();
        $answer = $this->getDoctrine()->getRepository('BankrotSiteBundle:ForumAnswer')->find($answerId);
        if ($answer){
            $this->getDoctrine()->getManager()->remove($answer);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Удаление вопроса
     * @Route("questions/delete/{questionId}", name="questions-delete")
     */
    public function questionDeleteAction(Request $request, $questionId){
        $question = $this->getDoctrine()->getRepository('BankrotSiteBundle:ForumQuestion')->find($questionId);
        if ($question){
            $this->getDoctrine()->getManager()->remove($question);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Удаление темы
     * @Route("theme/delete/{themeId}", name="theme-delete")
     */
    public function themeDeleteAction(Request $request, $themeId){
        $theme = $this->getDoctrine()->getRepository('BankrotSiteBundle:ForumTheme')->find($themeId);
        if ($theme){
            $this->getDoctrine()->getManager()->remove($theme);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

}