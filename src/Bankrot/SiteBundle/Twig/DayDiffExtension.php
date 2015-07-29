<?php

namespace Bankrot\SiteBundle\Twig;

class DayDiffExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('day_diff', array($this, 'dayDiff')),
        );
    }

    public function dayDiff($start, $finish=null)
    {
        $start = new \DateTime($start);
        $finish = new \DateTime($finish);

        return $start->diff($finish)->d;
    }

    public function getName()
    {
        return 'gay_diff';
    }
}