<?php

namespace FondOfImpala\Zed\CompanyPriceListGui\Communication\Plugin\CompanyGuiExtension;

use Spryker\Zed\CompanyGuiExtension\Dependency\Plugin\CompanyFormExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \FondOfImpala\Zed\CompanyPriceListGui\Communication\CompanyPriceListGuiCommunicationFactory getFactory()
 */
class PriceListCompanyFormExpanderPlugin extends AbstractPlugin implements CompanyFormExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder): void
    {
        $companyPriceListFormDataProvider = $this->getFactory()->createCompanyPriceListFormDataProvider();
        $companyPriceListForm = $this->getFactory()->createCompanyPriceListForm();

        $companyPriceListForm->buildForm($builder, $companyPriceListFormDataProvider->getOptions());
    }
}
