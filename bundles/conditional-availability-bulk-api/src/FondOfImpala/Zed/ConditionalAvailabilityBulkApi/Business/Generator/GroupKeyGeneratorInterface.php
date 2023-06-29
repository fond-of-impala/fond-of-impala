<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator;

interface GroupKeyGeneratorInterface
{
    /**
     * @param array $apiData
     *
     * @return string|null
     */
    public function generateByApiData(array $apiData): ?string;
}
