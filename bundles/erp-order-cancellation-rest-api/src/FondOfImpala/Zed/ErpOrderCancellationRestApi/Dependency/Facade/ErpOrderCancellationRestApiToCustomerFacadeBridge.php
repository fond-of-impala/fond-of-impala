<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class ErpOrderCancellationRestApiToCustomerFacadeBridge implements ErpOrderCancellationRestApiToCustomerFacadeInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected CustomerFacadeInterface $customerFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(CustomerFacadeInterface $customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param string $reference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function findByReference(string $reference): ?CustomerTransfer
    {
        return $this->customerFacade->findByReference($reference);
    }
}
