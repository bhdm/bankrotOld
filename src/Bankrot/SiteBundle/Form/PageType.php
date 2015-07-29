<?php

namespace Bankrot\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null, array('label' => 'Заголовок'))
            ->add('url',null, array('label' => 'URL страницы'))
            ->add('keywords',null, array('label' => 'Мета слова'))
            ->add('description',null, array('label' => 'Мета описание'))
            ->add('h1',null, array('label' => 'H1 заголовок'))
            ->add('body',null, array('label' => 'Контент страницы', 'attr' => array('class'=>'ckeditor')))
            ->add('submit', 'submit', array('label' => 'Сохранить'));

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wzc_mainbundle_page';
    }
}
