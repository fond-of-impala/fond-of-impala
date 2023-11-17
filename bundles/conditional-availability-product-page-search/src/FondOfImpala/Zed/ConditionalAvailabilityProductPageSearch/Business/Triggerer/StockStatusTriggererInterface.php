<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Triggerer;

interface StockStatusTriggererInterface
{
    /**
     * @return void
     */
    public function trigger(): void;
}
