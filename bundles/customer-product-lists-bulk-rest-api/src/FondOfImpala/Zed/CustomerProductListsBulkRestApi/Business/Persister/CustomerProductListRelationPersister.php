<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper\CustomerProductListRelationMapperInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

class CustomerProductListRelationPersister implements CustomerProductListRelationPersisterInterface
{
    protected CustomerProductListRelationMapperInterface $customerProductListRelationMapper;

    protected CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper\CustomerProductListRelationMapperInterface $customerProductListRelationMapper
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade
     */
    public function __construct(
        CustomerProductListRelationMapperInterface $customerProductListRelationMapper,
        CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade
    ) {
        $this->customerProductListRelationMapper = $customerProductListRelationMapper;
        $this->customerProductListConnectorFacade = $customerProductListConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return void
     */
    public function persist(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): void {
        $customerProductListRelationTransfer = $this->customerProductListRelationMapper
            ->fromRestProductListsBulkRequestAssignmentTransfer(
                $restProductListsBulkRequestAssignmentTransfer,
            );

        if ($customerProductListRelationTransfer === null) {
            return;
        }

        $this->customerProductListConnectorFacade->persistCustomerProductListRelation(
            $customerProductListRelationTransfer,
        );
    }
}
