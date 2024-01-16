<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Business\Model;

use FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CompanyUserQuoteExpander implements CompanyUserQuoteExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     */
    public function __construct(CompanyUserQuoteToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade)
    {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        if ($quoteTransfer->getCompanyUser() !== null || $quoteTransfer->getCompanyUserReference() === null) {
            return $quoteTransfer;
        }

        $companyUserTransfer = (new CompanyUserTransfer())
            ->setCompanyUserReference($quoteTransfer->getCompanyUserReference());

        $companyUserResponseTransfer = $this->companyUserReferenceFacade
            ->findCompanyUserByCompanyUserReference($companyUserTransfer);

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $companyUserResponseTransfer->getIsSuccessful() === false) {
            return $quoteTransfer;
        }

        return $quoteTransfer->setCompanyUser($companyUserTransfer);
    }
}
