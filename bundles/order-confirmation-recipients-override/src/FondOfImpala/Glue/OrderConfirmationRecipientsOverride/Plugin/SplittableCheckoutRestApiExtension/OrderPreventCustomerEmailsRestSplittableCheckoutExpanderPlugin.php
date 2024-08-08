<?php

namespace FondOfImpala\Glue\OrderConfirmationRecipientsOverride\Plugin\SplittableCheckoutRestApiExtension;

use FondOfOryx\Glue\SplittableCheckoutRestApiExtension\Dependency\Plugin\RestSplittableCheckoutExpanderPluginInterface;
use Generated\Shared\Transfer\RestSplittableCheckoutTransfer;
use Generated\Shared\Transfer\SplittableCheckoutTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

class OrderPreventCustomerEmailsRestSplittableCheckoutExpanderPlugin extends AbstractPlugin implements RestSplittableCheckoutExpanderPluginInterface
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
        $preventOrderMails = [];

        foreach ($splittableCheckoutTransfer->getSplittedQuotes() as $splitQuote) {
            $preventOrderMail = $splitQuote->getPreventCustomerOrderConfirmationMail();
            $splitKey = $splitQuote->getSplitKey();

            if ($splitKey === null || $preventOrderMail === null) {
                continue;
            }

            $preventOrderMails[$splitKey] = $preventOrderMail;
        }

        if (count($preventOrderMails) === 0) {
            return $restSplittableCheckoutTransfer;
        }

        return $restSplittableCheckoutTransfer->setPreventCustomerOrderConfirmationMails($preventOrderMails);
    }
}
