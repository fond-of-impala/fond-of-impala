<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence;

interface CompanyTypeRoleRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function findActiveCompanyUserIdsByIdCustomer(int $idCustomer): array;
}
