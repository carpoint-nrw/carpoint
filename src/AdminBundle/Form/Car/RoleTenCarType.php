<?php

namespace AdminBundle\Form\Car;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleTenCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleTenCarType extends AbstractCarType
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
            ->add('fhnr', null, ['required' => false])
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
            ->add('ourDiscountPrice', null, ['required' => false, 'scale' => 0])
            ->add('completed', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('carCondition', ChoiceType::class, $this->getCarCondition($builder))
            ->add('colorGerman', null, [
                'required' => false,
                'choice_label' => 'german',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.german', 'ASC');
                },
            ])
            ->add('colorPolish', null, [
                'required' => false,
                'choice_label' => 'polish',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.polish', 'ASC');
                },
            ])
            ->add('standartComplectationGerman', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('complectationGerman', null, ['required' => false])
            ->add('paid', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('documents', null, ['required' => false])
            ->add('downloadDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('shippingCost', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('shippingCostType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'disabled' => 'disabled'
            ])
            ->add('transportInvoiceNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('pay', null, ['required' => false])
            ->add('location', null, ['required' => false])
            ->add('radioCode', null, ['required' => false, 'attr' => ['maxlength' => '4']])
            ->add('salePriceWithOutVAT', null, ['required' => false])
            ->add('salePriceWithOutVATType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ]
            ])
            ->add('salePriceWithVAT', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('salePriceWithVATType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'disabled' => 'disabled'
            ])
            ->add('information', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('discharge', null, ['required' => false])
            ->add('sellingPrice', null, ['required' => false])
            ->add('seller', null, [
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.isVisible = :isVisible')
                        ->setParameter('isVisible', false)
                        ->orderBy('u.firstName', 'ASC');
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
            ->add('deposit', null, ['required' => false]);
    }
}