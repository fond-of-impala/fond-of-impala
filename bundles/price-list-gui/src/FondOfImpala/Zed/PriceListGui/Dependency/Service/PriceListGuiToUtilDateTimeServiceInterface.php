<?php

namespace FondOfImpala\Zed\PriceListGui\Dependency\Service;

interface PriceListGuiToUtilDateTimeServiceInterface
{
    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatDateTime($date): string;
}
