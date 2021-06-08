<?php

namespace AdminBundle\Form\Car;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleSixCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleSixCarType extends AbstractCarType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder.
     * @param array                $options The options.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $customerAttr = [
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
            },
        ];
        if (isset($options['attr']['type']) && $options['attr']['type'] === 'edit' && $options['attr']['editCustomer']) {
            $customerAttr['disabled'] = 'disabled';
        }

        $builder
            ->add('customer', null, $customerAttr)
            ->add('vinNumber', null, ['required' => false, 'disabled' => 'disabled', 'attr' => ['maxlength' => '17', 'minlength' => '17']])
            ->add('brand', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('model', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('versionPolish', null, [
                'required' => false,
                'choice_label' => 'polish',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.polish', 'ASC');
                },
            ])
            ->add('versionGerman', null, [
                'required' => false,
                'choice_label' => 'german',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.german', 'ASC');
                },
            ])
            ->add('carRegistration', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('carMileage', null, ['required' => false])
            ->add('completed', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('vendor', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('place', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('carCondition', ChoiceType::class, $this->getCarCondition($builder))
            ->add('colorPolish', null, [
                'required' => false,
                'choice_label' => 'polish',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.polish', 'ASC');
                },
            ])
            ->add('colorGerman', null, [
                'required' => false,
                'choice_label' => 'german',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.german', 'ASC');
                },
            ])
            ->add('standartComplectationPolish', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('standartComplectationGerman', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('complectationPolish', null, ['required' => false])
            ->add('complectationGerman', null, ['required' => false])
            ->add('initialVatPrice', null, ['required' => false, 'disabled' => 'disabled', 'scale' => 0])
            ->add('initialPriceWithOutVat', null, ['required' => false, 'disabled' => 'disabled', 'scale' => 0])
            ->add('minimumSellingPrice', null, ['required' => false, 'disabled' => 'disabled', 'scale' => 0])
            ->add('priceRoleSix', null, ['required' => false])
            ->add('paid', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('documents', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('downloadDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('pay', null, ['required' => false])
            ->add('targetUnload', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('forwarder', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('shippingCost', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('shippingCostType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'disabled' => 'disabled'
            ])
            ->add('location', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('radioCode', null, ['required' => false, 'attr' => ['maxlength' => '4']])
            ->add('user', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.firmNumber', 'ASC');
                },
            ])
            ->add('salePriceWithOutVAT', null, ['required' => false])
            ->add('salePriceWithOutVATType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
            ])
            ->add('salePriceWithVAT', null, ['required' => false])
            ->add('salePriceWithVATType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
            ])
            ->add('salesInvoiceNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('paidSuccess', null, ['required' => false])
            ->add('invoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('information', null, ['required' => false])
            ->add('declaration', null, ['required' => false, 'disabled' => 'disabled']);
    }
}