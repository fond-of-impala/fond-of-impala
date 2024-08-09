<?php

namespace FondOfImpala\Glue\SplittableCheckoutOrderTypeConnector\Plugin\SplittableCheckoutRestApiExtension;

use FondOfOryx\Glue\SplittableCheckoutRestApiExtension\Dependency\Plugin\RestSplittableCheckoutExpanderPluginInterface;
use Generated\Shared\Transfer\RestSplittableCheckoutTransfer;
use Generated\Shared\Transfer\SplittableCheckoutTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

class OrderTypesRestSplittableCheckoutExpanderPlugin extends AbstractPlugin implements RestSplittableCheckoutExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\SplittableCheckoutTransfer $splittableCheckoutTransfer
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutTransfer $restSplittableCheckoutTransfer
     *
     * @return \Generated\Shared\Transfer\RestSplittableCheckoutTransfer
     */
    public function expand(
        SplittableCheckoutTransfer $splittableCheckoutTransfer,
        RestSplittableCheckoutTransfer $restSplittableCheckoutTransfer
    ): RestSplittableCheckoutTransfer {
        $orderTypes = [];

        foreach ($splittableCheckoutTransfer->getSplittedQuotes() as $splitQuote) {
            $orderType = $splitQuote->getOrderType();
            $splitKey = $splitQuote->getSplitKey();

            if ($splitKey === null || $orderType === null) {
                continue;
            }

            $orderTypes[$splitKey] = $orderType;
        }

        if (count($orderTypes) === 0) {
            return $restSplittableCheckoutTransfer;
        }

        return $restSplittableCheckoutTransfer->setOrderTypes($orderTypes);
    }
}
