<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander;

use Exception;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;

class SalesOrderExpander implements SalesOrderExpanderInterface
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
     * @param \Generated\Shared\Transfer\SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderEntityTransfer
     */
    public function expand(
        SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer,
        QuoteTransfer $quoteTransfer
    ): SpySalesOrderEntityTransfer {
        $orderType = $quoteTransfer->getOrderType();

        if ($orderType === null && $this->config->getAllowEmptyOrderType()) {
            return $spySalesOrderEntityTransfer->setOrderType($orderType);
        }

        if ($orderType !== null && $this->orderTypeValidator->validateOrderType($orderType) === true) {
            return $spySalesOrderEntityTransfer->setOrderType($orderType);
        }

        if ($orderType === null) {
            throw new Exception('Order type is required');
        }

        throw new Exception(sprintf('Order type "%s" is not valid', $orderType));
    }
}
