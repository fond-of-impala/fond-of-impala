<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerReader implements CustomerReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface $repository
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorRepositoryInterface $repository,
        ConditionalAvailabilityCartConnectorToCustomerFacadeInterface $customerFacade
    ) {
        $this->repository = $repository;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerByCustomerReference(string $customerReference): CustomerTransfer
    {
        $idCustomer = $this->repository->getIdCustomerByCustomerReference($customerReference);
        $customerTransfer = (new CustomerTransfer())->setIdCustomer($idCustomer);

        return $this->customerFacade->getCustomer($customerTransfer);
    }
}
