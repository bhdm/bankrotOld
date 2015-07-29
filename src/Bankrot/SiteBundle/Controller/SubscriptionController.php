<?php

namespace Bankrot\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class
 * @Security("has_role('ROLE_USER')")
 * @Route("/subscription")
 */
class SubscriptionController extends Controller
{
    /**
     * @Route("/", name="subscription_index")
     * @Template("")
     */
    public function indexAction(){
        return array();
    }


    /**
     * @Route("/", name="subscription_success")
     * @Template("")
     */
    public function successAction(){
        return array();
    }


}