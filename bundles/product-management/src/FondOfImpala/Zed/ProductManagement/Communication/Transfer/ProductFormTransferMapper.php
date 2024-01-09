<?php

namespace FondOfImpala\Zed\ProductManagement\Communication\Transfer;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Product\Persistence\ProductQueryContainerInterface;
use Spryker\Zed\ProductManagement\Communication\Form\DataProvider\LocaleProvider;
use Spryker\Zed\ProductManagement\Communication\Helper\ProductConcreteSuperAttributeFilterHelperInterface;
use Spryker\Zed\ProductManagement\Communication\Transfer\ProductFormTransferMapper as SprykerProductFormTransferMapper;
use Spryker\Zed\ProductManagement\Dependency\Facade\ProductManagementToLocaleInterface;
use Spryker\Zed\ProductManagement\Persistence\ProductManagementQueryContainerInterface;
use Symfony\Component\Form\FormInterface;

class ProductFormTransferMapper extends SprykerProductFormTransferMapper
{
    /**
     * @var array<\FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTransferMapperExpanderPluginInterface>
     */
    protected array $productAbstractFormTransferMapperExpanderPlugins;

    /**
     * @param \Spryker\Zed\Product\Persistence\ProductQueryContainerInterface $productQueryContainer
     * @param \Spryker\Zed\ProductManagement\Persistence\ProductManagementQueryContainerInterface $productManagementQueryContainer
     * @param \Spryker\Zed\ProductManagement\Dependency\Facade\ProductManagementToLocaleInterface $localeFacade
     * @param \Spryker\Zed\ProductManagement\Communication\Form\DataProvider\LocaleProvider $localeProvider
     * @param array<\Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductFormTransferMapperExpanderPluginInterface> $productFormTransferMapperExpanderPlugins
     * @param array<\FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTransferMapperExpanderPluginInterface> $productAbstractFormTransferMapperExpanderPlugins
     * @param \Spryker\Zed\ProductManagement\Communication\Helper\ProductConcreteSuperAttributeFilterHelperInterface $productConcreteSuperAttributeFilterHelperInterface
     */
    public function __construct(
        ProductQueryContainerInterface $productQueryContainer,
        ProductManagementQueryContainerInterface $productManagementQueryContainer,
        ProductManagementToLocaleInterface $localeFacade,
        LocaleProvider $localeProvider,
        array $productFormTransferMapperExpanderPlugins,
        array $productAbstractFormTransferMapperExpanderPlugins,
        ProductConcreteSuperAttributeFilterHelperInterface $productConcreteSuperAttributeFilterHelperInterface
    ) {
        parent::__construct($productQueryContainer, $productManagementQueryContainer, $localeFacade, $localeProvider, $productFormTransferMapperExpanderPlugins, $productConcreteSuperAttributeFilterHelperInterface);
        $this->productAbstractFormTransferMapperExpanderPlugins = $productAbstractFormTransferMapperExpanderPlugins;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function buildProductAbstractTransfer(FormInterface $form, $idProductAbstract): ProductAbstractTransfer
    {
        $productAbstractTransfer = parent::buildProductAbstractTransfer($form, $idProductAbstract);

        $formData = $form->getData();

        foreach ($this->productAbstractFormTransferMapperExpanderPlugins as $plugin) {
            $productAbstractTransfer = $plugin->map($productAbstractTransfer, $formData);
        }

        return $productAbstractTransfer;
    }
}
