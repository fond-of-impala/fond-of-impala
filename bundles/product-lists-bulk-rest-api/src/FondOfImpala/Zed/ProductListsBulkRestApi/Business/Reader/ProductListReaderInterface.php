<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader;

interface ProductListReaderInterface
{
    /**
     * @param array<string> $uuids
     *
     * @return array<int>
     */
    public function getIdsByUuids(array $uuids): array;

    /**
     * @param array<string> $keys
     *
     * @return array<int>
     */
    public function getIdsByKeys(array $keys): array;

    /**
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByGroupedIdentifier(array $groupedIdentifiers): array;
}
