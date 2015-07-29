<?php

namespace Bankrot\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username',null, array('label' => 'логин'))
                ->add('email',null, array('label' => 'E-mail'))
                ->add('subscriptionDate',null, array('label' => 'Дата подписки'))
                ->add('submit', 'submit', array('label' => 'Сохранить'));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_user';
    }
}
