<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;

class ProductListReader implements ProductListReaderInterface
{
    protected CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade
     */
    public function __construct(
        CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface $customerProductListConnectorFacade
    ) {
        $this->customerProductListConnectorFacade = $customerProductListConnectorFacade;
    }

    /**
     * @param int $idCustomer
     *
     * @return array<int>
     */
    public function getIdsByIdCustomer(int $idCustomer): array
    {
        return $this->customerProductListConnectorFacade->getAssignedProductListIdsByIdCustomer($idCustomer);
    }
}
