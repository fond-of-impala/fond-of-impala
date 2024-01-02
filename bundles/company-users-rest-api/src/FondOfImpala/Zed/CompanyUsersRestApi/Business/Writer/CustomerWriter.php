<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer;

use DateTimeImmutable;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerWriter implements CustomerWriterInterface
{
    protected CustomerMapperInterface $customerMapper;

    protected RandomPasswordGeneratorInterface $randomPasswordGenerator;

    protected RestorePasswordKeyGeneratorInterface $restorePasswordKeyGenerator;

    protected RestorePasswordLinkGeneratorInterface $restorePasswordLinkGenerator;

    protected CompanyUsersRestApiToCustomerFacadeInterface $customerFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapperInterface $customerMapper
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGeneratorInterface $randomPasswordGenerator
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGeneratorInterface $restorePasswordKeyGenerator
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGeneratorInterface $restorePasswordLinkGenerator
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
     */
    public function __construct(
        CustomerMapperInterface $customerMapper,
        RandomPasswordGeneratorInterface $randomPasswordGenerator,
        RestorePasswordKeyGeneratorInterface $restorePasswordKeyGenerator,
        RestorePasswordLinkGeneratorInterface $restorePasswordLinkGenerator,
        CompanyUsersRestApiToCustomerFacadeInterface $customerFacade
    ) {
        $this->customerFacade = $customerFacade;
        $this->randomPasswordGenerator = $randomPasswordGenerator;
        $this->restorePasswordKeyGenerator = $restorePasswordKeyGenerator;
        $this->restorePasswordLinkGenerator = $restorePasswordLinkGenerator;
        $this->customerMapper = $customerMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function createByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer
    {
        $customerTransfer = $this->customerMapper->fromRestCustomer($restCustomerTransfer);

        $restorePasswordKey = $this->restorePasswordKeyGenerator->generate();

        $customerTransfer->setPassword($this->randomPasswordGenerator->generate())
            ->setRestorePasswordKey($restorePasswordKey)
            ->setRestorePasswordDate((new DateTimeImmutable()))// @phpstan-ignore-line
            ->setRestorePasswordLink($this->restorePasswordLinkGenerator->generate($restorePasswordKey))
            ->setIsNew(true);

        $customerResponseTransfer = $this->customerFacade->addCustomer($customerTransfer);
        $customerTransfer = $customerResponseTransfer->getCustomerTransfer();

        if ($customerTransfer === null || $customerResponseTransfer->getIsSuccess() === false) {
            return null;
        }

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function createByRestCompanyUsersRequestAttributes(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CustomerTransfer {
        $restCustomerTransfer = $restCompanyUsersRequestAttributesTransfer->getCustomer();

        if ($restCustomerTransfer === null) {
            return null;
        }

        return $this->createByRestCustomer($restCustomerTransfer);
    }
}
