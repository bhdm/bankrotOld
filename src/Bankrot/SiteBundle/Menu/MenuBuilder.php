<?php

namespace Bankrot\SiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $currentRoute = $requestStack->getCurrentRequest()->get('_route');

        $menu
            ->setChildrenAttribute('class', 'nav navbar-nav')
            ->addChild('Торги', ['route' => 'home'])
                ->getParent()
            ->addChild('Планировщик', ['route' => 'lots_list'])
                ->setCurrent(0 === strpos($currentRoute, 'lots'))
                ->getParent()
            ->addChild('Реестры', ['uri' => '#'])
                ->getParent()
            ->addChild('Форум', ['route' => 'forum_index'])
                ->getParent()
            ->addChild('Будьте осторожны', ['route' => 'page','routeParameters'=>['url' => 'warning']])
                ->getParent()
            ->addChild('Контакты', ['route' => 'page','routeParameters'=>['url' => 'contacts']])
                ->getParent()
            ;

        return $menu;
    }

    public function createLotsMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $currentRoute = $requestStack->getCurrentRequest()->get('_route');

        $menu
            ->setChildrenAttribute('class', 'nav navbar-nav')
            ->addChild('Активные', ['route' => 'lots_list'])
                ->setCurrent('lots_list' === $currentRoute)
                ->getParent()
            ->addChild('Неактивные', ['route' => 'lots_list_inactive'])
                ->setCurrent('lots_list_inactive' === $currentRoute)
                ->getParent()
            ->addChild('Архив', ['route' => 'lots_list_archive'])
                ->setCurrent('lots_list_archive' === $currentRoute)
                ->getParent()
            ;

        return $menu;
    }
}
