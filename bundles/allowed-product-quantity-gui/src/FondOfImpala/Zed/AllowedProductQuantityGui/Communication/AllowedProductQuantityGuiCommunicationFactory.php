<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication;

use FondOfImpala\Zed\AllowedProductQuantityGui\AllowedProductQuantityGuiDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider\AllowedQuantityFormDataProvider;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\FormExpander\ProductAbstractFormExpander;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\FormExpander\ProductAbstractFormExpanderInterface;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander\ProductAbstractTabExpander;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander\ProductAbstractTabExpanderInterface;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\ViewExpander\ProductAbstractViewExpander;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\ViewExpander\ProductAbstractViewExpanderInterface;
use FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class AllowedProductQuantityGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander\ProductAbstractTabExpanderInterface
     */
    public function createProductAbstractTabExpander(): ProductAbstractTabExpanderInterface
    {
        return new ProductAbstractTabExpander();
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\ViewExpander\ProductAbstractViewExpanderInterface
     */
    public function createProductAbstractViewExpander(): ProductAbstractViewExpanderInterface
    {
        return new ProductAbstractViewExpander();
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\FormExpander\ProductAbstractFormExpanderInterface
     */
    public function createProductAbstractFormExpander(): ProductAbstractFormExpanderInterface
    {
        return new ProductAbstractFormExpander(
            $this->createAllowedQuantityForm(),
            $this->createAllowedQuantityFormDataProvider(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm
     */
    protected function createAllowedQuantityForm(): AllowedQuantityForm
    {
        return new AllowedQuantityForm();
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider\AllowedQuantityFormDataProvider
     */
    protected function createAllowedQuantityFormDataProvider(): AllowedQuantityFormDataProvider
    {
        return new AllowedQuantityFormDataProvider($this->getAllowedProductQuantityFacade());
    }

    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface
     */
    protected function getAllowedProductQuantityFacade(): AllowedProductQuantityGuiToAllowedProductQuantityFacadeInterface
    {
        return $this->getProvidedDependency(AllowedProductQuantityGuiDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY);
    }
}
