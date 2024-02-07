<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;

class ProductListReader implements ProductListReaderInterface
{
    protected CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade
     */
    public function __construct(
        CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade
    ) {
        $this->companyProductListConnectorFacade = $companyProductListConnectorFacade;
    }

    /**
     * @param int $idCompany
     *
     * @return array<int>
     */
    public function getIdsByIdCompany(int $idCompany): array
    {
        return $this->companyProductListConnectorFacade->getAssignedProductListIdsByIdCompany($idCompany);
    }
}
