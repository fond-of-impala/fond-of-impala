<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacade;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface $customerFacade
     * @param \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     */
    public function __construct(
        CollaborativeCartToCustomerFacadeInterface $customerFacade,
        CollaborativeCartToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
    ) {
        $this->customerFacade = $customerFacade;
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->expandWithOriginalCustomer($quoteTransfer);

        return $this->expandWithOriginalCompanyUser($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function expandWithOriginalCustomer(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        if ($quoteTransfer->getOriginalCustomer() !== null || $quoteTransfer->getOriginalCustomerReference() === null) {
            return $quoteTransfer;
        }

        $customerTransfer = $this->customerFacade
            ->findByReference($quoteTransfer->getOriginalCustomerReference());

        if ($customerTransfer === null) {
            return $quoteTransfer;
        }

        return $quoteTransfer->setOriginalCustomer($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function expandWithOriginalCompanyUser(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        if (
            $quoteTransfer->getOriginalCompanyUser() !== null
            || $quoteTransfer->getOriginalCompanyUserReference() === null
        ) {
            return $quoteTransfer;
        }

        $companyUserTransfer = (new CompanyUserTransfer())
            ->setCompanyUserReference($quoteTransfer->getOriginalCompanyUserReference());

        $customerResponseTransfer = $this->companyUserReferenceFacade
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);

        if (!$customerResponseTransfer->getIsSuccessful() || $customerResponseTransfer->getCompanyUser() === null) {
            return $quoteTransfer;
        }

        return $quoteTransfer->setOriginalCompanyUser($customerResponseTransfer->getCompanyUser());
    }
}
