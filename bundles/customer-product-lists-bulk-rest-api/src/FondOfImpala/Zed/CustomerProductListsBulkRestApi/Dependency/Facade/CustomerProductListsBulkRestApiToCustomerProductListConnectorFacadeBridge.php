<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade;

use FondOfOryx\Zed\CustomerProductListConnector\Business\CustomerProductListConnectorFacadeInterface;
use Generated\Shared\Transfer\CustomerProductListRelationTransfer;

class CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeBridge implements CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface
{
    protected CustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade;

    /**
     * @param \FondOfOryx\Zed\CustomerProductListConnector\Business\CustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade
     */
    public function __construct(CustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade)
    {
        $this->customerProductListConnectorFacade = $customerProductListConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerProductListRelationTransfer $customerProductListRelationTransfer
     *
     * @return void
     */
    public function persistCustomerProductListRelation(
        CustomerProductListRelationTransfer $customerProductListRelationTransfer
    ): void {
        $this->customerProductListConnectorFacade->persistCustomerProductListRelation(
            $customerProductListRelationTransfer,
        );
    }

    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function getAssignedProductListIdsByIdCustomer(int $idCustomer): array
    {
        return $this->customerProductListConnectorFacade->getAssignedProductListIdsByIdCustomer($idCustomer);
    }
}
