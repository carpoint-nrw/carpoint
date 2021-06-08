<?php

namespace AdminBundle\Form\Car;

use AdminBundle\Enum\CarShowPrices;
use AdminBundle\Enum\UserRoleEnum;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleFourTeenCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleFourTeenCarType extends AbstractCarType
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
        $builder
            ->add('customer', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('vinNumber', null, ['required' => false, 'attr' => ['maxlength' => '17', 'minlength' => '17', 'readonly' => 'readonly']])
            ->add('brand', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('model', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('versionPolish', null, [
                'required' => false,
                'choice_label' => 'polish',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.polish', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('versionGerman', null, [
                'required' => false,
                'choice_label' => 'german',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.german', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('carRegistration', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly'],
            ])
            ->add('carMileage', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('completed', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly'],
            ])
            ->add('carCondition', ChoiceType::class, $this->getCarCondition($builder, UserRoleEnum::ROLE_ADMIN_14))
            ->add('colorPolish', null, [
                'required' => false,
                'choice_label' => 'polish',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.polish', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('colorGerman', null, [
                'required' => false,
                'choice_label' => 'german',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.german', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('standartComplectationPolish', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('standartComplectationGerman', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('complectationPolish', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('complectationGerman', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('initialVatPrice', null, ['required' => false, 'scale' => 0, 'attr' => ['readonly' => 'readonly']])
            ->add('initialPriceWithOutVat', null, ['required' => false, 'scale' => 0, 'attr' => ['readonly' => 'readonly']])
            ->add('ourDiscountPrice', null, ['required' => false, 'scale' => 2, 'attr' => ['readonly' => 'readonly']])
            ->add('discount', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('priceRoleFive', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('priceRoleSix', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('priceRoleSeven', null, ['required' => false])
            ->add('documents', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('downloadDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly']
            ])
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
                'disabled' => 'disabled',
            ])
            ->add('shippingCost', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('shippingCostType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'disabled' => 'disabled',
            ])
            ->add('location', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
                'disabled' => 'disabled',
            ])
            ->add('orderNumber', null, ['required' => false])
            ->add('radioCode', null, ['required' => false, 'attr' => ['maxlength' => '4', 'readonly' => 'readonly']])
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
            ->add('salesInvoiceNumber', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('paidSuccess', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('invoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly']
            ])
            ->add('information', null, ['required' => false])
            ->add('seller', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.firstName', 'ASC');
                },
                'disabled' => 'disabled',
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
            ->add('zakupBrut', null, ['required' => false, 'scale' => 2, 'attr' => ['readonly' => 'readonly']])
            ->add('vat', null, ['required' => false, 'scale' => 2, 'attr' => ['readonly' => 'readonly']])
            ->add('dataPro2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('dataFv2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('zysk', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])

            ->add('demo', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('ekBrutto', null, ['required' => false])
            ->add('mwst', null, ['required' => false])
            ->add('carlineDate', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('carlineNumber', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])

            ->add('mwst', null, ['required' => false])
            ->add('ekNetto', null, ['required' => false])
            ->add('taxType', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('gewinn', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('sellingPrice', null, ['required' => false])
            ->add('preisTr', null, ['required' => false])
            ->add('ust', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('restsumme', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('deposit', null, ['required' => false])
            ->add('nrPro2', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('invoiceNumber', null, ['required' => false]);

        $type = $options['attr']['type'];
        if ($type === 'edit') {
            $builder
                ->add('saveCarlinePdf', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary'],
                ]);
        }
    }
}