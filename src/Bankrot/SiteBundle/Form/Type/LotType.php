<?php

namespace Bankrot\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Наименование', 'attr' => ['placeholder' => 'Введите наименование']])
            ->add('category', null, ['label' => 'Категория'])
            ->add('url', 'url', ['label' => 'Ссылка на лот', 'attr' => ['placeholder' => 'Введите ссылку на лот']])
            ->add('phone', null, ['label' => 'Телефон', 'attr' => ['placeholder' => 'Введите телефон']])
            ->add('price', null, ['label' => 'Рыночная стоимость', 'attr' => ['placeholder' => 'Введите рыночную стоимость']])
            ->add('address', null, ['label' => 'Адрес', 'attr' => ['placeholder' => 'Введите адрес']])
            ->add('description', null, ['label' => 'Описание', 'attr' => ['rows' => 5, 'placeholder' => 'Введите описание']])
            ->add('initialPrice', null, ['label' => 'Начальная стоимость', 'attr' => ['placeholder' => 'Введите начальную стоимость']])
            ->add('cutOffPrice', null, ['attr' => ['placeholder' => 'Введите значение в рублях']])
            ->add('cutOffPricePercent', null, ['attr' => ['placeholder' => 'Введите значение в процентах от начальной стоимости']])
            ->add('depositPrice', null, ['attr' => ['placeholder' => 'Введите значение в рублях']])
            ->add('depositPricePercent', null, ['attr' => ['placeholder' => 'Введите значение в процентах от начальной стоимости']])
            ->add('depositPricePercentCurrent', null, ['attr' => ['placeholder' => 'Введите значение в процентах от стоимости текущего периода']])
            ->add('lotStatus', null, ['label' => 'Статус лота'])
//            ->add('lotStatus', null, ['label' => 'Статус лота', 'empty_value' => '-'])
            ->add('livePeriod', 'text', ['mapped' => false, 'label' => 'Период жизни лота', 'attr' => [
                'data-inputmask' => '99.99.9999 - 99.99.9999', 
                'placeholder' => 'Введите период жизни лота',
            ]])
            ->add('newDropRulePeriod', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите период'], 'constraints' => [
                new Assert\Range(['min' => 0]),
            ]])
            ->add('newDropRulePeriodWork', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите период'], 'constraints' => [
                new Assert\Range(['min' => 0]),
            ]])
            ->add('newDropRuleOrder', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите порядок снижения'], 'constraints' => [
                new Assert\Range(['min' => 0]),
            ]])
            ->add('newDropRuleOrderCurrent', 'text', ['mapped' => false, 'attr' => ['placeholder' => 'Введите порядок снижения'], 'constraints' => [
                new Assert\Range(['min' => 0, 'max' => 100]),
            ]])
            ->add('newDropRuleLivePeriod', 'text', ['mapped' => false, 'label' => 'Период действия', 'attr' => [
                'data-inputmask' => '99.99.9999 - 99.99.9999', 
                'placeholder' => 'Введите период действия',
            ]])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Bankrot\SiteBundle\Entity\Lot',
        ]);
    }

    public function getName()
    {
        return 'lot';
    }
}
