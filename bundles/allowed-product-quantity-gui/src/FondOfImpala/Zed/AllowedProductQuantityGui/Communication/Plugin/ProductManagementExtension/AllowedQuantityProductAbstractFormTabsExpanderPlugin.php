<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Plugin\ProductManagementExtension;

use FondOfImpala\Zed\ProductManagement\Dependency\Plugin\ProductAbstractFormTabsExpanderPluginInterface;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\AllowedProductQuantityGuiCommunicationFactory getFactory()
 */
class AllowedQuantityProductAbstractFormTabsExpanderPlugin extends AbstractPlugin implements ProductAbstractFormTabsExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expand(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        return $this->getFactory()->createProductAbstractTabExpander()->expand($tabsViewTransfer);
    }
}
