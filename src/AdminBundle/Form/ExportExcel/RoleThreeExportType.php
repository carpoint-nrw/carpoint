<?php

namespace AdminBundle\Form\ExportExcel;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleThreeExportType
 *
 * @package AdminBundle\Form\ExportExcel
 */
class RoleThreeExportType extends AbstractExportType
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
            ->add('vendor', CheckboxType::class, [
                'required' => false,
                'label' => 'Vendor'
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
            ->add('versionPolish', CheckboxType::class, [
                'required' => false,
                'label' => 'Version Polish'
            ])
            ->add('versionGerman', CheckboxType::class, [
                'required' => false,
                'label' => 'Version German'
            ])
            ->add('colorPolish', CheckboxType::class, [
                'required' => false,
                'label' => 'Color Polish'
            ])
            ->add('standartComplectationPolish', CheckboxType::class, [
                'required' => false,
                'label' => 'Polish Complectation'
            ])
            ->add('complectationPolish', CheckboxType::class, [
                'required' => false,
                'label' => 'Complectation Polish'
            ])
            ->add('ourDiscountPrice', CheckboxType::class, [
                'required' => false,
                'label' => 'Our discount price'
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
            ->add('paymentDate', CheckboxType::class, [
                'required' => false,
                'label' => 'Payment date'
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
            ->add('orderNumber', CheckboxType::class, [
                'required' => false,
                'label' => 'Order number'
            ])
            ->add('information', CheckboxType::class, [
                'required' => false,
                'label' => 'Information'
            ])
            ->add('invoiceNumber', CheckboxType::class, [
                'required' => false,
                'label' => 'Invoice number'
            ])
            ->add('language', ChoiceType::class, [
                'choices'  => [
                    $user->getLocale() === 'pl' ? 'Polski' : 'Polski' => 'pl',
                    $user->getLocale() === 'pl' ? 'Deutsch' : 'Deutsch' => 'de',
                ],
                'data' => $user->getLocale() === 'pl' ? 'pl' : 'de',
            ]);
    }
}