<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CustomerProductListRelationTransfer;

interface CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerProductListRelationTransfer $customerProductListRelationTransfer
     *
     * @return void
     */
    public function persistCustomerProductListRelation(
        CustomerProductListRelationTransfer $customerProductListRelationTransfer
    ): void;

    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function getAssignedProductListIdsByIdCustomer(int $idCustomer): array;
}
