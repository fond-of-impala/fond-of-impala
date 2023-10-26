<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence;

interface CompanyCartSearchRestApiRepositoryInterface
{
    /**
     * @param int $idCustomer
     * @param string $companyUuid
     *
     * @return int|null
     */
    public function getIdCompanyByIdCustomerAndCompanyUuid(
        int $idCustomer,
        string $companyUuid
    ): ?int;

    /**
     * @param string $key
     *
     * @return int|null
     */
    public function getIdPermissionByKey(string $key): ?int;
}
