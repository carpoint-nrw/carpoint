<?php

namespace AdminBundle\Form\ExportExcel\Statistics;

use AdminBundle\Form\ExportExcel\AbstractExportType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RoleOneExportType
 *
 * @package AdminBundle\Form\ExportExcel
 */
class RoleOneExportType extends AbstractExportType
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
            ->add('ankauf', CheckboxType::class, [
                'required' => false,
                'label'    => 'Ankauf'
            ])
            ->add('brand', CheckboxType::class, [
                'required' => false,
                'label'    => 'Brand'
            ])
            ->add('model', CheckboxType::class, [
                'required' => false,
                'label'    => 'Model'
            ])
            ->add('zustand', CheckboxType::class, [
                'required' => false,
                'label'    => 'Zustand'
            ])
            ->add('vinNumber', CheckboxType::class, [
                'required' => false,
                'label'    => 'Vin number'
            ])
            ->add('customer', CheckboxType::class, [
                'required' => false,
                'label'    => 'Customer'
            ])
            ->add('ekNetto', CheckboxType::class, [
                'required' => false,
                'label'    => 'ekNetto C.'
            ])
            ->add('ekBrutto', CheckboxType::class, [
                'required' => false,
                'label'    => 'ekBrutto C.'
            ])
            ->add('ust', CheckboxType::class, [
                'required' => false,
                'label'    => 'ust C.'
            ])
            ->add('invoiceNumber', CheckboxType::class, [
                'required' => false,
                'label'    => 'Invoice number'
            ])
            ->add('paymentDate', CheckboxType::class, [
                'required' => false,
                'label'    => 'Payment date'
            ])
            ->add('preisTr', CheckboxType::class, [
                'required' => false,
                'label'    => 'Preis Tr.'
            ])
            ->add('datumPayFour', CheckboxType::class, [
                'required' => false,
                'label'    => 'Datum'
            ])
            ->add('orderNumber', CheckboxType::class, [
                'required' => false,
                'label'    => 'Bestellnummer'
            ])
            ->add('datum', CheckboxType::class, [
                'required' => false,
                'label'    => 'Vertragsdatum'
            ])
            ->add('company', CheckboxType::class, [
                'required' => false,
                'label'    => 'Kunde'
            ])
            ->add('rechnungsnr', CheckboxType::class, [
                'required' => false,
                'label'    => 'Rech. Nr.'
            ])
            ->add('reDatum', CheckboxType::class, [
                'required' => false,
                'label'    => 'Rech. Datum'
            ])
            ->add('paymentType', CheckboxType::class, [
                'required' => false,
                'label'    => 'Zahlungsart'
            ])
            ->add('zahldatum', CheckboxType::class, [
                'required' => false,
                'label'    => 'Zahldatum'
            ])
            ->add('vkNetto', CheckboxType::class, [
                'required' => false,
                'label'    => 'VK Netto'
            ])
            ->add('vkBrutto', CheckboxType::class, [
                'required' => false,
                'label'    => 'VK Brutto'
            ])
            ->add('gewinn', CheckboxType::class, [
                'required' => false,
                'label' => 'gewinn C.'
            ])
            ->add('seller', CheckboxType::class, [
                'required' => false,
                'label'    => 'Seller C.'
            ])
            ->add('infoStatistic', CheckboxType::class, [
                'required' => false,
                'label'    => 'Info'
            ])
            ->add('standtage', CheckboxType::class, [
                'required' => false,
                'label'    => 'Standtage'
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