<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Persistence;

/**
 * @codeCoverageIgnore
 */
interface ProductListsBulkRestApiRepositoryInterface
{
    /**
     * @param array<string> $keys
     *
     * @return array<string, int>
     */
    public function getProductListIdsByKeys(array $keys): array;

    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getProductListIdsByUuids(array $uuids): array;
}
