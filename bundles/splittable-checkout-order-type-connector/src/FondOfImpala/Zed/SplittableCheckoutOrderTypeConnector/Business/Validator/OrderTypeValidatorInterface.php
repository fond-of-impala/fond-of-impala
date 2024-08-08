<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator;

interface OrderTypeValidatorInterface
{
    /**
     * @param string $orderType
     *
     * @return bool
     */
    public function validateOrderType(string $orderType): bool;
}
