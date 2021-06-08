<?php

namespace AdminBundle\Form\ExportExcel;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleTwelveExportType
 *
 * @package AdminBundle\Form\ExportExcel
 */
class RoleTwelveExportType extends AbstractExportType
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
        $user = $this->storage->getToken()->getUser();

        $builder
            ->add('ids', HiddenType::class)
            ->add('address1', CheckboxType::class, [
                'required' => false,
                'label' => 'address1'
            ])
            ->add('customer', CheckboxType::class, [
                'required' => false,
                'label' => 'Customer'
            ])
            ->add('radioCode', CheckboxType::class, [
                'required' => false,
                'label' => 'Radio code'
            ])
            ->add('carCondition', CheckboxType::class, [
                'required' => false,
                'label' => 'Car condition'
            ])
            ->add('vinNumber', CheckboxType::class, [
                'required' => false,
                'label' => 'Vin number'
            ])
            ->add('brand', CheckboxType::class, [
                'required' => false,
                'label' => 'Brand'
            ])
            ->add('model', CheckboxType::class, [
                'required' => false,
                'label' => 'Model'
            ])
            ->add('versionGerman', CheckboxType::class, [
                'required' => false,
                'label' => 'Version German'
            ])
            ->add('colorGerman', CheckboxType::class, [
                'required' => false,
                'label' => 'Color German'
            ])
            ->add('standartComplectationGerman', CheckboxType::class, [
                'required' => false,
                'label' => 'German Complectation'
            ])
            ->add('complectationGerman', CheckboxType::class, [
                'required' => false,
                'label' => 'Complectation German'
            ])
            ->add('carRegistration', CheckboxType::class, [
                'required' => false,
                'label' => 'Car registration'
            ])
            ->add('carMileage', CheckboxType::class, [
                'required' => false,
                'label' => 'Car mileage'
            ])
            ->add('initialVatPrice', CheckboxType::class, [
                'required' => false,
                'label' => 'Initial vat price'
            ])
            ->add('initialPriceWithOutVat', CheckboxType::class, [
                'required' => false,
                'label' => 'Initial price without vat'
            ])
            ->add('completed', CheckboxType::class, [
                'required' => false,
                'label' => 'Completed'
            ])
            ->add('paid', CheckboxType::class, [
                'required' => false,
                'label' => 'Paid'
            ])
            ->add('documents', CheckboxType::class, [
                'required' => false,
                'label' => 'Documents'
            ])
            ->add('downloadDate', CheckboxType::class, [
                'required' => false,
                'label' => 'Download date'
            ])
            ->add('targetUnload', CheckboxType::class, [
                'required' => false,
                'label' => 'Target unload E.'
            ])
            ->add('address3', CheckboxType::class, [
                'required' => false,
                'label' => 'address2'
            ])
            ->add('address3', CheckboxType::class, [
                'required' => false,
                'label' => 'address2'
            ])
            ->add('location', CheckboxType::class, [
                'required' => false,
                'label' => 'Location'
            ])
            ->add('information', CheckboxType::class, [
                'required' => false,
                'label' => 'Information'
            ])
            ->add('language', ChoiceType::class, [
                'choices'  => [
                    $user->getLocale() === 'pl' ? 'Polski' : 'Polski' => 'pl',
                    $user->getLocale() === 'pl' ? 'Deutsch' : 'Deutsch' => 'de',
                ],
                'data' => $user->getLocale() === 'pl' ? 'pl' : 'de',
            ])
            ->add('user', CheckboxType::class, [
                'required' => false,
                'label' => 'Buyer E.'
            ])
            ->add('ekNetto', CheckboxType::class, [
                'required' => false,
                'label' => 'ekNetto C.'
            ])
            ->add('ekBrutto', CheckboxType::class, [
                'required' => false,
                'label' => 'ekBrutto C.'
            ])
            ->add('ust', CheckboxType::class, [
                'required' => false,
                'label' => 'ust C.'
            ])
            ->add('datum', CheckboxType::class, [
                'required' => false,
                'label' => 'Carpoint Datum'
            ])
            ->add('seller', CheckboxType::class, [
                'required' => false,
                'label' => 'Seller C.'
            ])
            ->add('additionalWork', CheckboxType::class, [
                'required' => false,
                'label' => 'Additional work C.'
            ])
            ->add('date', CheckboxType::class, [
                'required' => false,
                'label' => 'Date C.'
            ]);
    }
}