<?php

namespace AdminBundle\Form\Car;

use AdminBundle\Enum\CarShowPrices;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleNineCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleNineCarType extends AbstractCarType
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
            ->add('fhnr', null, ['required' => false])
            ->add('discharge', null, ['required' => false])
            ->add('brand', null, ['required' => false])
            ->add('model', null, ['required' => false])
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
            ->add('complectationPolish', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('complectationGerman', null, ['required' => false])
            ->add('initialVatPrice', null, ['required' => false, 'scale' => 0])
            ->add('initialPriceWithOutVat', null, ['required' => false, 'scale' => 0])
            ->add('priceRoleFive', null, ['required' => false])
            ->add('priceRoleSix', null, ['required' => false])
            ->add('priceRoleSeven', null, ['required' => false])
            ->add('invoiceNumber', null, ['required' => false])
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
            ->add('forwarder', null, [
                'required' => false,
                'disabled' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('targetUnload', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('shippingCost', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('transportInvoiceNumber', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('discount', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('pay', null, ['required' => false, 'disabled' => true])
            ->add('location', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
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
            ->add('information', null, ['required' => false])
            ->add('sellingPrice', null, ['required' => false])
            ->add('seller', null, [
                'required' => false,
                'disabled' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.firstName', 'ASC');
                },
            ])
            ->add('notes', null, ['required' => false])
            ->add('date', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('placeOfIssue', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('carVisibility', null, [
                'required' => false,
                'label'    => 'Carpoint',
            ])
            ->add('showPrice', ChoiceType::class, [
                'choices'  => [
                    'Preis 1' => CarShowPrices::PRISE_1,
                    'Preis 2' => CarShowPrices::PRISE_2,
                    'Preis 3' => CarShowPrices::PRISE_3,
                ],
                'expanded' => true,
                'required' => true,
            ])
            ->add('paymentDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('shippingCostType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('firmNumber', null, ['required' => false])
            ->add('firma', null, ['required' => false])
            ->add('firstName', null, ['required' => false])
            ->add('lastName', null, ['required' => false])
            ->add('street', null, ['required' => false])
            ->add('placeIndex', null, ['required' => false])
            ->add('city', null, ['required' => false])
            ->add('email', null, ['required' => false])
            ->add('phoneNumber', null, ['required' => false])
            ->add('mobileNumber', null, ['required' => false])
            ->add('fax', null, ['required' => false])
            ->add('datum',DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('ptsNumber', null, ['required' => false])
            ->add('deposit', null, ['required' => false])
            ->add('clientStatus', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('bodyType', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('carStatus', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('fuel', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('paymentCondition', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('paymentType', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('taxType', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('ort', null, [
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('additionalWork', null, ['required' => false])

            ->add('vat', null, ['required' => false, 'scale' => 2, 'attr' => ['readonly' => 'readonly']])
            ->add('nrPro2', null, ['required' => false])
            ->add('dataPro2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('dataFv2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('zysk', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('ekNetto', null, ['required' => false])
            ->add('preisTr', null, ['required' => false])
            ->add('pay5', null, ['required' => false, 'label' => 'bezahlt'])
            ->add('paidSuccess', null, ['required' => false])
            ->add('invoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('salesInvoiceNumber', null, ['required' => false])
            ->add('ourDiscountPrice', null, ['required' => false, 'scale' => 2])
            ->add('zakupBrut', null, ['required' => false, 'scale' => 2])
            ->add('ekBrutto', null, ['required' => false])
            ->add('ust', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('demo', null, ['required' => false])
            ->add('importTax', null, ['required' => false, 'scale' => 2])
            ->add('taxNumber', null, ['required' => false])
            ->add('taxReturned', null, ['required' => false])
            ->add('data2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('mwst', null, ['required' => false])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->add('carInvoiceNumber', null, [
                'required' => false,
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('carInvoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('proformaNumber', null, [
                'required' => false,
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('proformaDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('gewinn', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('registrationCertificate', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('registrationCertificateDescription', null, ['required' => false]);

        $type = $options['attr']['type'];
        if ($type === 'edit') {
            $builder
                ->add('saveCarpointPdf', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary'],
                ])
                ->add('saveInvoiceAccountPdf', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary'],
                ])
                ->add('certificate', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary'],
                ]);
        }
    }
}