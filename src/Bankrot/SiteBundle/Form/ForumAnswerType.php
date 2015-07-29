<?php
namespace Bankrot\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForumAnswerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', null, array('label' => ' ', 'attr' => array('class' => 'minickeditor')))
            ->add('file', 'iphp_file', array('label' => 'Файл'))
            ->add('submit', 'submit', array('label' => 'Ответить', 'attr' => array('class' => 'btn btn-default')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\ForumAnswer'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_forumanswer';
    }
}