<?php

namespace FondOfImpala\Zed\PriceListGui\Dependency\Service;

use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;

class PriceListGuiToUtilDateTimeServiceBridge implements PriceListGuiToUtilDateTimeServiceInterface
{
    protected UtilDateTimeServiceInterface $utilDateTimeService;

    /**
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     */
    public function __construct(UtilDateTimeServiceInterface $utilDateTimeService)
    {
        $this->utilDateTimeService = $utilDateTimeService;
    }

    /**
     * @param \DateTime|string $date
     *
     * @return string
     */
    public function formatDateTime($date): string
    {
        return $this->utilDateTimeService->formatDateTime($date);
    }
}
