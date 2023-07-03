<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator;

class GroupKeyGenerator implements GroupKeyGeneratorInterface
{
    /**
     * @var array<string>
     */
    public const REQUIRED_API_DATA_KEYS = [
        'warehouse_group',
        'channel',
    ];

    /**
     * @param array $apiData
     *
     * @return string|null
     */
    public function generateByApiData(array $apiData): ?string
    {
        $groupKeyParts = [];

        foreach (static::REQUIRED_API_DATA_KEYS as $dataKey) {
            if (!isset($apiData[$dataKey])) {
                return null;
            }

            $groupKeyParts[] = $apiData[$dataKey];
        }

        return sha1(implode('-', $groupKeyParts));
    }
}
