<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CompanyProductListRelationTransfer;

interface CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyProductListRelationTransfer $companyProductListRelationTransfer
     *
     * @return void
     */
    public function persistCompanyProductListRelation(
        CompanyProductListRelationTransfer $companyProductListRelationTransfer
    ): void;

    /**
     * @param int $idCompany
     *
     * @return array<int>
     */
    public function getAssignedProductListIdsByIdCompany(int $idCompany): array;
}
