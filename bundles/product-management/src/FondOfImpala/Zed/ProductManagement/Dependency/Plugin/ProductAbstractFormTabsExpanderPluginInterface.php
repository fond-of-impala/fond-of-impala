<?php

namespace FondOfImpala\Zed\ProductManagement\Dependency\Plugin;

use Generated\Shared\Transfer\TabsViewTransfer;

interface ProductAbstractFormTabsExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands form tabs for ProductFormAdd.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expand(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer;
}
