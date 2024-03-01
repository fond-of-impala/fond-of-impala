<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper\CompanyProductListRelationMapperInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

class CompanyProductListRelationPersister implements CompanyProductListRelationPersisterInterface
{
    protected CompanyProductListRelationMapperInterface $companyProductListRelationMapper;

    protected CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper\CompanyProductListRelationMapperInterface $companyProductListRelationMapper
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade
     */
    public function __construct(
        CompanyProductListRelationMapperInterface $companyProductListRelationMapper,
        CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface $companyProductListConnectorFacade
    ) {
        $this->companyProductListRelationMapper = $companyProductListRelationMapper;
        $this->companyProductListConnectorFacade = $companyProductListConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return void
     */
    public function persist(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): void {
        $companyProductListRelationTransfer = $this->companyProductListRelationMapper
            ->fromRestProductListsBulkRequestAssignmentTransfer(
                $restProductListsBulkRequestAssignmentTransfer,
            );

        if ($companyProductListRelationTransfer === null) {
            return;
        }

        $this->companyProductListConnectorFacade->persistCompanyProductListRelation(
            $companyProductListRelationTransfer,
        );
    }
}
