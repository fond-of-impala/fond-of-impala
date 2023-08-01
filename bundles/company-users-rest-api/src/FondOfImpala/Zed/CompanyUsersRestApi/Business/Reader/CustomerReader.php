<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader;

use Exception;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerReader implements CustomerReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface
     */
    protected $customerMapper;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface $customerMapper
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        CustomerMapperInterface $customerMapper,
        CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
    ) {
        $this->customerMapper = $customerMapper;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer
    {
        $customerTransfer = $this->customerMapper->fromRestCustomer($restCustomerTransfer);

        try {
            return $this->customerFacade->getCustomer($customerTransfer);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getByRestCompanyUsersRequestAttributes(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CustomerTransfer {
        $restCustomerTransfer = $restCompanyUsersRequestAttributesTransfer->getCustomer();

        if ($restCustomerTransfer === null) {
            return null;
        }

        return $this->getByRestCustomer($restCustomerTransfer);
    }
}
