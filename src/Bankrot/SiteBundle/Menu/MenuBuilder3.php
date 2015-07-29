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
        $routeName = $requestStack->getCurrentRequest()->get('_route');

        $menu = $this->factory->createItem('root')
            ->setChildrenAttribute('class', 'nav navbar-nav');

        $lotsItem = $menu->addChild('Мониторинг', ['route' => 'home']);

        $calendItem = $menu->addChild('Планировщик', ['route' => 'calend']);
        $calendItem = $menu->addChild('Блог', ['route' => 'forum_index']);

        if (0 === strpos($routeName, 'lot') || 'home' === $routeName) {
            $lotsItem->setCurrent(true);
        } elseif ($routeName === 'calend') {
            $calendItem->setCurrent(true);
        }

        return $menu;
    }

    public function createAuthMenu(RequestStack $requestStack)
    {
        $routeName = $requestStack->getCurrentRequest()->get('_route');

        $menu = $this->factory->createItem('root')
            ->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        $menu->addChild('Вход', ['route' => 'fos_user_security_login'])
            ->setCurrent('fos_user_security_login' === $routeName || 0 === strpos($routeName, 'fos_user_resetting'));

        $menu->addChild('Регистрация', ['route' => 'fos_user_registration_register'])
            ->setCurrent('fos_user_registration_register' === $routeName);

        return $menu;
    }

    public function createAuthLoggedMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root')
            ->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        $menu->addChild('Выход', ['route' => 'fos_user_security_logout']);

        return $menu;
    }
}
