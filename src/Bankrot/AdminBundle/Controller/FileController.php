<?php

namespace Bankrot\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Bankrot\SiteBundle\Entity\File;

/**
 * Class FilesController
 * @package Wzc\AdminBundle\Controller
 * @Route("/admin/file")
 */
class FileController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="admin_file_list")
     * @Template()
     */
    //defaults={"folderId"="null"}
    public function listAction($folderId = null){
//        if ( $folderId ){
//            $parent = $this->getDoctrine()->getRepository('WzcMainBundle:File')->findOneById($folderId);
//        }else{
//            $parent = null;
//        }
        $files = $this->getDoctrine()->getRepository('BankrotSiteBundle:File')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $files,
            $this->get('request')->query->get('page', 1),
            40
        );
        return array(
            'domain' => $_SERVER['SERVER_NAME'],
//            'folder'    => $parent,
            'pagination'     => $pagination
        );
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/add/{folderId}", name="admin_file_add", defaults={"folderId"="null"})
     * @Template()
     */
    public function addAction(Request $request, $folderId = null){

        $file = new File();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder($file);
//        $form->add('title',null, array('label' => 'Название файла'));
        $form->add('file','iphp_file', array('label' => 'файл'));
        $form->add('submit', 'submit', array('label' => 'Сохранить'));
        $form = $form->getForm();

        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $item = $formData->getData();
                $em->persist($item);
                $em->flush($item);
                return $this->redirect($this->generateUrl('admin_file_list',array('folderId' => $folderId)));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/remove/{fileId}", name="admin_file_remove")
     */
    public function removeFileAction(Request $request, $fileId){
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('BankrotSiteBundle:File')->findOneById($fileId);
        if ($file){
            $em->remove($file);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
}