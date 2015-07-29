<?php
namespace Bankrot\AdminBundle\Controller;

use Bankrot\SiteBundle\Entity\Notify;
use Bankrot\SiteBundle\Form\NotifyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Bankrot\SiteBundle\Entity\Page;
use Bankrot\SiteBundle\Form\PageType;

/**
 * Class PageController
 * @package Bankrot\AdminBundle\Controller
 * @Route("/admin/notify")
 */
class NotifyController extends Controller{
        const ENTITY_NAME = 'Page';
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="admin_notify")
     * @Template()
     */
    public function notifyAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository('BankrotSiteBundle:Notify')->findOneByEnabled(true);
        $form = $this->createForm(new NotifyType($em), $item);
        $formData = $form->handleRequest($request);

        if ($request->getMethod() == 'POST'){
            if ($formData->isValid()){
                $notifies = $em->getRepository('BankrotSiteBundle:Notify')->findAll();
                foreach($notifies as $notify){
                    $em->remove($notify);
                }
                $em->flush();

                $item = $formData->getData();
                $em->persist($item);
                $em->flush();
                $em->refresh($item);
                return $this->redirect($this->generateUrl('admin_notify'));
            }
        }
        return array('form' => $form->createView());
    }

}