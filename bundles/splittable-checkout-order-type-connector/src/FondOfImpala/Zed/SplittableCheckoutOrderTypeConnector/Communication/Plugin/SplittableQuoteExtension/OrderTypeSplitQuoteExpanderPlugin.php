<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Communication\Plugin\SplittableQuoteExtension;

use FondOfOryx\Zed\SplittableQuoteExtension\Dependency\Plugin\SplittedQuoteExpanderPluginInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class OrderTypeSplitQuoteExpanderPlugin extends AbstractPlugin implements SplittedQuoteExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $splitQuoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $splitQuoteTransfer): QuoteTransfer
    {
        $splitKey = $splitQuoteTransfer->getSplitKey();
        $orderTypes = $splitQuoteTransfer->getOrderTypes();

        if (count($orderTypes) === 0) {
            return $splitQuoteTransfer;
        }

        $orderType = !isset($orderTypes[$splitKey]) ? null : $orderTypes[$splitKey];

        return $splitQuoteTransfer->setOrderType($orderType);
    }
}
