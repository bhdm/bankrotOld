<?php
namespace Bankrot\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Bankrot\SiteBundle\Entity\ForumQuestion;
use Bankrot\SiteBundle\Form\ForumQuestionType;

/**
 * Class ForumQuestionController
 * @package Bankrot\AdminBundle\Controller
 * @Route("/admin/forumquestion")
 */
class ForumQuestionController extends Controller{
        const ENTITY_NAME = 'ForumQuestion';
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="admin_forumquestion_list")
     * @Template()
     */
    public function listAction(){
        $items = $this->getDoctrine()->getRepository('BankrotSiteBundle:'.self::ENTITY_NAME)->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $items,
            $this->get('request')->query->get('page', 1),
            20
        );

        return array('pagination' => $pagination);
    }


    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/edit/{id}", name="admin_forumquestion_edit")
     * @Template()
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getRepository('BankrotSiteBundle:'.self::ENTITY_NAME)->findOneById($id);
        $form = $this->createForm(new ForumQuestionType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->flush($item);
                $em->refresh($item);
                return $this->redirect($this->generateUrl('admin_forumquestion_list'));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/remove/{id}", name="admin_forumquestion_remove")
     */
    public function removeAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('BankrotSiteBundle:'.self::ENTITY_NAME)->findOneById($id);
        if ($item){
            $em->remove($item);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}