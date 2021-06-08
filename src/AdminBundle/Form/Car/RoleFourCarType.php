<?php

namespace AdminBundle\Form\Car;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleFourCarType
 *
 * @package AdminBundle\Form\Car
 */
class RoleFourCarType extends AbstractCarType
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
        $customerAttr = ['required' => false];
        if (isset($options['attr']['type']) && $options['attr']['type'] === 'edit' && $options['attr']['editCustomer']) {
            $customerAttr['disabled'] = 'disabled';
        }

        $builder
            ->add('customer', null, $customerAttr)
            ->add('vinNumber', null, ['required' => false, 'disabled' => 'disabled', 'attr' => ['maxlength' => '17', 'minlength' => '17']])
            ->add('brand', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('model', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('versionPolish', null, ['required' => false, 'choice_label' => 'polish', 'disabled' => 'disabled'])
            ->add('versionGerman', null, ['required' => false, 'choice_label' => 'german', 'disabled' => 'disabled'])
            ->add('carRegistration', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('carMileage', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('completed', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('vendor', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('initialVatPrice', null, ['required' => false, 'disabled' => 'disabled', 'scale' => 0])
            ->add('initialPriceWithOutVat', null, ['required' => false, 'disabled' => 'disabled', 'scale' => 0])
            ->add('ourDiscountPrice', null, ['required' => false, 'disabled' => 'disabled', 'scale' => 0])
            ->add('discount', null, ['required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('invoiceNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('paid', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('shippingCost', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('shippingCostType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'disabled' => 'disabled'
            ])
            ->add('transportInvoiceNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('pay', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('orderNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('user', null, ['required' => false])
            ->add('salePriceWithOutVAT', null, ['required' => false])
            ->add('salePriceWithOutVATType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
            ])
            ->add('salePriceWithVAT', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('salePriceWithVATType', ChoiceType::class, [
                'choices'  => [
                    'PLN' => 'PLN',
                    'EUR' => 'EUR',
                ],
                'disabled' => 'disabled'
            ])
            ->add('salesInvoiceNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('paidSuccess', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('invoiceDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'disabled' => 'disabled'
            ])
            ->add('declaration', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('importTax', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('taxNumber', null, ['required' => false, 'disabled' => 'disabled'])
            ->add('taxReturned', null, ['required' => false, 'disabled' => 'disabled']);
    }
}