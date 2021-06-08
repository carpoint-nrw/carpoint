<?php

namespace AdminBundle\Form\Car;

use AdminBundle\Enum\CarShowPrices;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleTwoCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleTwoCarType extends AbstractCarType
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
            ->add('vinNumber', null, ['required' => false, 'attr' => ['maxlength' => '17', 'minlength' => '17']])
            ->add('brand', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('model', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
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
            ])
            ->add('vendor', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('place', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
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
            ->add('initialVatPrice', null, ['required' => false, 'scale' => 0])
            ->add('initialPriceWithOutVat', null, ['required' => false, 'scale' => 0, 'attr' => ['readonly' => 'readonly']])
            ->add('ourDiscountPrice', null, ['required' => false, 'scale' => 2])
            ->add('discount', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('priceRoleFive', null, ['required' => false])
            ->add('priceRoleSix', null, ['required' => false])
            ->add('priceRoleSeven', null, ['required' => false])
            ->add('invoiceNumber', null, ['required' => false])
            ->add('paymentDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('paid', null, ['required' => false])
            ->add('ankauf', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('documents', null, ['required' => false])
            ->add('downloadDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('pay', null, ['required' => false])
            ->add('targetUnload', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('forwarder', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('shippingCost', null, ['required' => false])
            ->add('shippingCostType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
            ])
            ->add('transportInvoiceNumber', null, ['required' => false])
            ->add('location', null, ['required' => false])
            ->add('orderNumber', null, ['required' => false])
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
            ->add('salesInvoiceNumber', null, ['required' => false])
            ->add('paidSuccess', null, ['required' => false])
            ->add('invoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('information', null, ['required' => false])
            ->add('importTax', null, ['required' => false, 'scale' => 2])
            ->add('taxNumber', null, ['required' => false])
            ->add('taxReturned', null, ['required' => false])

            ->add('showPrice', ChoiceType::class, [
                'choices'  => [
                    'Preis 1' => CarShowPrices::PRISE_1,
                    'Preis 2' => CarShowPrices::PRISE_2,
                    'Preis 3' => CarShowPrices::PRISE_3,
                ],
                'expanded' => true,
                'required' => true,
            ])
            ->add('zakupBrut', null, ['required' => false, 'scale' => 2])
            ->add('vat', null, ['required' => false, 'scale' => 2, 'attr' => ['readonly' => 'readonly']])
            ->add('nrPro', null, ['required' => false])
            ->add('dataPro', DateType::class, ['required' => false, 'widget' => 'single_text'])
            ->add('pay4', null, ['required' => false, 'label' => 'zaplacona',])
            ->add('data2', DateType::class, ['required' => false, 'widget' => 'single_text'])
            ->add('nrFv', null, ['required' => false])
            ->add('dataFv', DateType::class, ['required' => false, 'widget' => 'single_text'])
            ->add('data1', DateType::class, ['required' => false, 'widget' => 'single_text'])
            ->add('nrPro2', null, ['required' => false])
            ->add('dataPro2', DateType::class, ['required' => false, 'widget' => 'single_text'])
            ->add('dataFv2', DateType::class, ['required' => false, 'widget' => 'single_text'])
            ->add('zysk', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('demo', null, ['required' => false])
            ->add('segregator', null, ['required' => false])
            ->add('carlineDate', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('carlineNumber', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->add('seller', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.firstName', 'ASC');
                },
                'disabled' => 'disabled',
            ]);

        $type = $options['attr']['type'];
        if ($type === 'edit') {
            $builder
                ->add('saveCarlinePdf', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary'],
                ])
                ->add('saveCarpointPdf', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary'],
                ]);
        }
    }
}