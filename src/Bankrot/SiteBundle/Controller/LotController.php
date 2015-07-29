<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Entity\Lot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LotController extends Controller
{
    /**
     * @Route("/lot/{id}", name="lot", requirements={"id": "\d+"})
     * @Template()
     * @ParamConverter("lot", class="BankrotParserBundle:Lot")
     */
    public function showAction(Lot $lot)
    {
        return [
            'lot' => $lot,
        ];
    }
}
