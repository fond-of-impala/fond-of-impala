<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Communication\Plugin\Sales;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface;

/**
 * @method \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\SplittableCheckoutOrderTypeConnectorFacadeInterface getFacade()
 */
class OrderTypeOrderExpanderPreSavePlugin extends AbstractPlugin implements OrderExpanderPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderEntityTransfer
     */
    public function expand(
        SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer,
        QuoteTransfer $quoteTransfer
    ): SpySalesOrderEntityTransfer {
        return $this->getFacade()->expandSalesOrder($spySalesOrderEntityTransfer, $quoteTransfer);
    }
}
