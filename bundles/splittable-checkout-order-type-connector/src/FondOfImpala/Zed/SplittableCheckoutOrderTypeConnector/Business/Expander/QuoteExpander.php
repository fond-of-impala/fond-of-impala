<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander;

use Exception;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    protected OrderTypeValidatorInterface $orderTypeValidator;

    protected SplittableCheckoutOrderTypeConnectorConfig $config;

    /**
     * @param \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface $orderTypeValidator
     * @param \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig $config
     */
    public function __construct(OrderTypeValidatorInterface $orderTypeValidator, SplittableCheckoutOrderTypeConnectorConfig $config)
    {
        $this->orderTypeValidator = $orderTypeValidator;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        $orderType = $restSplittableCheckoutRequestTransfer->getOrderType();

        if ($orderType === null) {
            return $quoteTransfer;
        }

        return $quoteTransfer->setOrderType($orderType);
    }

    /**
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandTypes(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        $orderTypes = $restSplittableCheckoutRequestTransfer->getOrderTypes();

        foreach ($orderTypes as &$orderType) {
            if (($orderType === null || $orderType === '') && $this->config->getAllowEmptyOrderType()) {
                $orderType = null;

                continue;
            }

            if ($orderType === null || $orderType === '') {
                $orderType = 'EMPTY';
            }

            if (!$this->orderTypeValidator->validateOrderType($orderType)) {
                throw new Exception(sprintf('Order type "%s" is not valid', $orderType));
            }
        }

        return $quoteTransfer->setOrderTypes($orderTypes);
    }
}
