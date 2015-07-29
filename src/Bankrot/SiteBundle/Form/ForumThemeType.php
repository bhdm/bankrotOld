<?php
namespace Bankrot\SiteBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ForumThemeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null, array('label' => 'Название раздела: ', 'attr' => array('class'=> 'styler')))
            ->add('body',null, array('label' => 'Описание', 'attr' => array('class'=> 'ckeditor')))
            ->add('submit','submit', array('label' => 'Сохранить', 'attr' => array('class'=> 'btn btn-default')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\ForumTheme'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_forumtheme';
    }
}