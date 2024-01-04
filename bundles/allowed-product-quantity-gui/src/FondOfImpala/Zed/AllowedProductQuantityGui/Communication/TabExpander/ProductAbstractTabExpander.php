<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;

class ProductAbstractTabExpander implements ProductAbstractTabExpanderInterface
{
    /**
     * @var string
     */
    public const TAB_ALLOWED_QUANTITY_NAME = 'allowed_quantity';

    /**
     * @var string
     */
    public const TAB_ALLOWED_QUANTITY_TITLE = 'Allowed Quantity';

    /**
     * @var string
     */
    public const TAB_ALLOWED_QUANTITY_TEMPLATE = '@AllowedProductQuantityGui/_partials/allowed-quantity-tab.twig';

    /**
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expand(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabItemTransfer = new TabItemTransfer();

        $tabItemTransfer
            ->setName(static::TAB_ALLOWED_QUANTITY_NAME)
            ->setTitle(static::TAB_ALLOWED_QUANTITY_TITLE)
            ->setTemplate(static::TAB_ALLOWED_QUANTITY_TEMPLATE);

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $tabsViewTransfer;
    }
}
