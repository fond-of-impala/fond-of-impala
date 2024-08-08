<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Expander;

use Exception;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface;
use FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;

class SalesOrderExpander implements SalesOrderExpanderInterface
{
    /**
     * @var array<string>
     */
    protected array $orderTypes;

    protected OrderTypeValidatorInterface $orderTypeValidator;

    protected SplittableCheckoutOrderTypeConnectorConfig $config;

    /**
     * \
     *
     * @param \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator\OrderTypeValidatorInterface $orderTypeValidator
     * @param \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConfig $config
     * @param array<string> $orderTypes
     */
    public function __construct(OrderTypeValidatorInterface $orderTypeValidator, SplittableCheckoutOrderTypeConnectorConfig $config, array $orderTypes)
    {
        $this->orderTypes = $orderTypes;
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

        if ($this->orderTypeValidator->validateOrderType($orderType) === true) {
            return $spySalesOrderEntityTransfer->setOrderType($orderType);
        }

        if ($orderType === null) {
            throw new Exception('Order type is required');
        }

        throw new Exception(sprintf('Order type "%s" is not valid', $orderType));
    }
}
