<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander;

use Generated\Shared\Transfer\TabsViewTransfer;

interface ProductAbstractTabExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expand(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer;
}
