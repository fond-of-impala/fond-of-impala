<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class CollaborativeCartToCustomerFacadeBridge implements CollaborativeCartToCustomerFacadeInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(CustomerFacadeInterface $customerFacade)
    {
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function findByReference(string $customerReference): ?CustomerTransfer
    {
        return $this->customerFacade->findByReference($customerReference);
    }
}
