<?php

namespace Bankrot\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Bankrot\SiteBundle\Entity\User;

class AuthController extends Controller
{
    /**
     * @Route("/admin/login", name="login")
     * @Template()
     */
    public function loginAction()
    {

//        $error = null;
//        if (!$this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
//            $error = 'Неправильный логин или пароль';
//        }
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
//        var_dump($error);
//        exit;
        return array(
            'error' => $error
        );
    }





}
