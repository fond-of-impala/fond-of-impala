<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

interface StockStatusTriggerInterface
{
    /**
     * @return void
     */
    public function trigger(): void;
}
