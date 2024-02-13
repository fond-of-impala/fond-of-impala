<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade;

use FondOfOryx\Zed\CompanyProductListConnector\Business\CompanyProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyProductListRelationTransfer;

class CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeBridge implements CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface
{
    protected CompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade;

    /**
     * @param \FondOfOryx\Zed\CompanyProductListConnector\Business\CompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade
     */
    public function __construct(CompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade)
    {
        $this->companyProductListConnectorFacade = $companyProductListConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyProductListRelationTransfer $companyProductListRelationTransfer
     *
     * @return void
     */
    public function persistCompanyProductListRelation(
        CompanyProductListRelationTransfer $companyProductListRelationTransfer
    ): void {
        $this->companyProductListConnectorFacade->persistCompanyProductListRelation(
            $companyProductListRelationTransfer,
        );
    }

    /**
     * @param int $idCompany
     *
     * @return array<int>
     */
    public function getAssignedProductListIdsByIdCompany(int $idCompany): array
    {
        return $this->companyProductListConnectorFacade->getAssignedProductListIdsByIdCompany($idCompany);
    }
}
