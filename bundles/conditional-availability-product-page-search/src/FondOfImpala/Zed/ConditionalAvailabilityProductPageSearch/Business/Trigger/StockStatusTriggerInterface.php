<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger;

interface StockStatusTriggerInterface
{
    /**
     * @return void
     */
    public function trigger(): void;

    /**
     * @return void
     */
    public function triggerDelta(): void;
}
