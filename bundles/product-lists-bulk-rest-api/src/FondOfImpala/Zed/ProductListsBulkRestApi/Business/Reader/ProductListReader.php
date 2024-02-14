<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepositoryInterface;

class ProductListReader implements ProductListReaderInterface
{
    protected ProductListsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(ProductListsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getIdsByUuids(array $uuids): array
    {
        return $this->repository->getProductListIdsByUuids($uuids);
    }

    /**
     * @param array<string> $keys
     *
     * @return array<string, int>
     */
    public function getIdsByKeys(array $keys): array
    {
        return $this->repository->getProductListIdsByKeys($keys);
    }

    /**
     * @param array<string, array<string>> $groupedIdentifiers
     *
     * @return array<string, int>
     */
    public function getIdsByGroupedIdentifier(array $groupedIdentifiers): array
    {
        $companyIds = [];

        if (count($groupedIdentifiers['uuid']) > 0) {
            $companyIds = array_merge($companyIds, $this->getIdsByUuids($groupedIdentifiers['uuid']));
        }

        if (count($groupedIdentifiers['key']) === 0) {
            return $companyIds;
        }

        return array_merge($companyIds, $this->getIdsByKeys($groupedIdentifiers['key']));
    }
}
