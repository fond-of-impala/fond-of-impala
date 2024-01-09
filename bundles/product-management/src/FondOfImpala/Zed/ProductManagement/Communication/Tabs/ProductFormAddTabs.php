<?php

namespace FondOfImpala\Zed\ProductManagement\Communication\Tabs;

use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\ProductManagement\Communication\Tabs\ProductFormAddTabs as SprykerProductFormAddTabs;

class ProductFormAddTabs extends SprykerProductFormAddTabs
{
    /**
     * @var array<\FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTabsExpanderPluginInterface>
     */
    protected array $productAbstractFormTabsExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTabsExpanderPluginInterface> $productAbstractFormTabsExpanderPlugins
     */
    public function __construct(
        array $productAbstractFormTabsExpanderPlugins = []
    ) {
        $this->productAbstractFormTabsExpanderPlugins = $productAbstractFormTabsExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function build(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabsViewTransfer = parent::build($tabsViewTransfer);

        return $this->executeExpanderPlugins($tabsViewTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    protected function executeExpanderPlugins(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        foreach ($this->productAbstractFormTabsExpanderPlugins as $productAbstractFormTabsExpanderPlugin) {
            $tabsViewTransfer = $productAbstractFormTabsExpanderPlugin->expand($tabsViewTransfer);
        }

        return $tabsViewTransfer;
    }
}
