<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\Validator;

class OrderTypeValidator implements OrderTypeValidatorInterface
{
    /**
     * @var string[]
     */
    protected array $orderTypes;

    /**
     * @param string[] $orderTypes
     */
    public function __construct(array $orderTypes)
    {
        $this->orderTypes = $orderTypes;
    }

    /**
     * @param string $orderType
     *
     * @return bool
     */
    public function validateOrderType(string $orderType): bool
    {
        return in_array($orderType, $this->orderTypes, true);
    }
}
