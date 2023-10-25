<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader;

interface CompanyReaderInterface
{
    /**
     * @param array $filterFieldTransfers
     *
     * @return int|null
     */
    public function getIdByFilterFields(array $filterFieldTransfers): ?int;
}
