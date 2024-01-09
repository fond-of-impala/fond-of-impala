<?php

namespace FondOfImpala\Zed\ProductManagement\Communication\Tabs;

use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\ProductManagement\Communication\Tabs\ProductFormEditTabs as SprykerProductFormEditTabs;

class ProductFormEditTabs extends SprykerProductFormEditTabs
{
    /**
     * @var array<\Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormEditTabsExpanderPluginInterface>
     */
    protected array $productAbstractFormTabsExpanderPlugins;

    /**
     * @param array<\Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormEditTabsExpanderPluginInterface> $productAbstractFormEditTabsExpanderPlugins
     */
    public function __construct(array $productAbstractFormEditTabsExpanderPlugins = [])
    {
        parent::__construct($productAbstractFormEditTabsExpanderPlugins);
        $this->productAbstractFormTabsExpanderPlugins = $productAbstractFormEditTabsExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function executeExpanderPlugins(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabsViewTransfer = parent::executeExpanderPlugins($tabsViewTransfer);

        foreach ($this->productAbstractFormTabsExpanderPlugins as $productAbstractFormTabsExpanderPlugin) {
            $tabsViewTransfer = $productAbstractFormTabsExpanderPlugin->expand($tabsViewTransfer);
        }

        return $tabsViewTransfer;
    }
}
