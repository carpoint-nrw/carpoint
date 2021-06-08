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
 * Class RoleElevenCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleElevenCarType extends AbstractCarType
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
            ->add('vendor', null, [
                'required' => false,
                'disabled' => true,
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
            ->add('customer', null, $customerAttr)
            ->add('vinNumber', null, ['required' => false, 'attr' => ['maxlength' => '17', 'minlength' => '17']])
            ->add('fhnr', null, ['required' => false])
            ->add('brand', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('user', null, [
                'required' => false,
                'disabled' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.firmNumber', 'ASC');
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
            ->add('carCondition', ChoiceType::class, $this->getCarCondition($builder, UserRoleEnum::ROLE_ADMIN_11))
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
            ->add('ourDiscountPrice', null, ['required' => false, 'scale' => 2])
            ->add('discount', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('initialPriceWithOutVat', null, ['required' => false, 'scale' => 0, 'attr' => ['readonly' => 'readonly']])
            ->add('initialVatPrice', null, ['required' => false, 'scale' => 0, 'attr' => ['readonly' => 'readonly']])
            ->add('completed', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly'],
            ])
            ->add('paymentDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('invoiceNumber', null, ['required' => false])
            ->add('paid', null, ['required' => false])
            ->add('ankauf', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('documents', null, ['required' => false])
            ->add('information', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('forwarder', null, [
                'required' => false,
                'attr' => ['readonly' => 'readonly'],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('downloadDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => ['readonly' => 'readonly'],
            ])
            ->add('targetUnload', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('location', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('radioCode', null, ['required' => false, 'attr' => ['maxlength' => '4']])
            ->add('discharge', null, ['required' => false])
            ->add('sellingPrice', null, ['required' => false])
            ->add('seller', null, [
                'required' => false,
                'disabled' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.firstName', 'ASC');
                },
            ])
            ->add('notes', null, ['required' => false])
            ->add('additionalWork', null, ['required' => false])
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
            ->add('clientStatus', null, [
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
            ->add('ort', null, [
                'required' => true,
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

            ->add('nrPro2', null, ['required' => false])
            ->add('dataPro2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
            ->add('dataFv2', DateType::class, ['required' => false, 'widget' => 'single_text', 'attr' => ['readonly' => 'readonly']])
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
            ->add('ekBrutto', null, ['required' => false])
            ->add('ust', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('demo', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('gewinn', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('zakupBrut', null, ['required' => false, 'scale' => 2])
            ->add('mwst', null, ['required' => false])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->add('carInvoiceNumber', null, [
                'required' => false,
            ])
            ->add('carInvoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('proformaNumber', null, [
                'required' => false,
            ])
            ->add('proformaDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('registrationCertificate', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.title', 'ASC');
                },
            ])
            ->add('zahldatumPay', null, ['required' => false])
            ->add('zahldatum', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
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