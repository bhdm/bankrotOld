<?php
namespace Bankrot\SiteBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class ForumQuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null, array('label' => 'Заголовок: ', 'attr' => array('class'=> 'styler')))
            ->add('body',null, array('label' => ' ', 'attr' => array('class'=> 'minickeditor')))
            ->add('submit','submit', array('label' => 'Сохранить', 'attr' => array('class'=> 'btn btn-default')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bankrot\SiteBundle\Entity\ForumQuestion'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'bankrot_sitebundle_forumquestion';
    }
}