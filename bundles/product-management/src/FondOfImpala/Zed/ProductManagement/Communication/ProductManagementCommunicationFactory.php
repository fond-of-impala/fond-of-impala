<?php

namespace FondOfImpala\Zed\ProductManagement\Communication;

use FondOfImpala\Zed\ProductManagement\Communication\Form\ProductConcreteFormAdd;
use FondOfImpala\Zed\ProductManagement\Communication\Form\ProductConcreteFormEdit;
use FondOfImpala\Zed\ProductManagement\Communication\Form\ProductFormAdd;
use FondOfImpala\Zed\ProductManagement\Communication\Form\ProductFormEdit;
use FondOfImpala\Zed\ProductManagement\Communication\Tabs\ProductFormAddTabs;
use FondOfImpala\Zed\ProductManagement\Communication\Tabs\ProductFormEditTabs;
use FondOfImpala\Zed\ProductManagement\Communication\Transfer\ProductFormTransferMapper;
use FondOfImpala\Zed\ProductManagement\ProductManagementDependencyProvider;
use Spryker\Zed\Gui\Communication\Tabs\TabsInterface;
use Spryker\Zed\ProductManagement\Communication\ProductManagementCommunicationFactory as SprykerProductManagementCommunicationFactory;
use Spryker\Zed\ProductManagement\Communication\Transfer\ProductFormTransferMapperInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\ProductManagement\ProductManagementConfig getConfig()
 * @method \Spryker\Zed\ProductManagement\Persistence\ProductManagementQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductManagement\Persistence\ProductManagementRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductManagement\Business\ProductManagementFacadeInterface getFacade()
 */
class ProductManagementCommunicationFactory extends SprykerProductManagementCommunicationFactory
{
    /**
     * @var string
     */
    public const PLUGINS_PRODUCT_ABSTRACT_FORM_TABS_EXPANDER = 'PLUGINS_PRODUCT_ABSTRACT_FORM_TABS_EXPANDER';

    /**
     * @param array $formData
     * @param array $formOptions
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductFormAdd(array $formData, array $formOptions = []): FormInterface
    {
        return $this->getFormFactory()->create(ProductFormAdd::class, $formData, $formOptions);
    }

    /**
     * @param array $formData
     * @param array $formOptions
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductFormEdit(array $formData, array $formOptions = []): FormInterface
    {
        return $this->getFormFactory()->create(ProductFormEdit::class, $formData, $formOptions);
    }

    /**
     * @param array $formData
     * @param array $formOptions
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getProductVariantFormAdd(array $formData, array $formOptions = []): FormInterface
    {
        return $this->getFormFactory()->create(ProductConcreteFormAdd::class, $formData, $formOptions);
    }

    /**
     * @param array $formData
     * @param array $formOptions
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductVariantFormEdit(array $formData, array $formOptions = []): FormInterface
    {
        return $this->getFormFactory()->create(ProductConcreteFormEdit::class, $formData, $formOptions);
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createProductFormAddTabs(): TabsInterface
    {
        return new ProductFormAddTabs(
            $this->getProductAbstractFormTabsExpanderPlugins(),
        );
    }

    /**
     * @return \Spryker\Zed\Gui\Communication\Tabs\TabsInterface
     */
    public function createProductFormEditTabs(): TabsInterface
    {
        return new ProductFormEditTabs(
            $this->getProductAbstractFormEditTabsExpanderPlugins(),
        );
    }

    /**
     * @return \Spryker\Zed\ProductManagement\Communication\Transfer\ProductFormTransferMapperInterface
     */
    public function createProductFormTransferGenerator(): ProductFormTransferMapperInterface
    {
        return new ProductFormTransferMapper(
            $this->getProductQueryContainer(),
            $this->getQueryContainer(),
            $this->getLocaleFacade(),
            $this->createLocaleProvider(),
            $this->getProductFormTransferMapperExpanderPlugins(),
            $this->getProductAbstractFormTransferMapperExpanderPlugins(),
            $this->createProductConcreteSuperAttributeFilterHelper(),
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTabsExpanderPluginInterface>
     */
    public function getProductAbstractFormTabsExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ProductManagementDependencyProvider::PLUGINS_PRODUCT_ABSTRACT_FORM_TABS_EXPANDER);
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTransferMapperExpanderPluginInterface>
     */
    public function getProductAbstractFormTransferMapperExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ProductManagementDependencyProvider::PLUGINS_PRODUCT_ABSTRACT_FORM_TRANSFER_MAPPER_EXPANDER);
    }
}
