<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business\Model;

use FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface
     */
    protected $collaborativeCartRepository;

    /**
     * @param \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface $collaborativeCartRepository
     */
    public function __construct(
        CollaborativeCartRepositoryInterface $collaborativeCartRepository
    ) {
        $this->collaborativeCartRepository = $collaborativeCartRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\ClaimCartRequestTransfer $claimCartRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveByClaimCartRequestAndQuote(
        ClaimCartRequestTransfer $claimCartRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): ?CompanyUserTransfer {
        $idCustomer = $claimCartRequestTransfer->getNewIdCustomer();

        if ($idCustomer === null) {
            return null;
        }

        $companyUser = $quoteTransfer->getCompanyUser();

        if (
            $companyUser === null
            || $companyUser->getFkCompany() === null
            || $companyUser->getFkCompanyBusinessUnit() === null
        ) {
            return null;
        }

        $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
            ->setIdCustomer($idCustomer)
            ->setIdCompany($companyUser->getFkCompany())
            ->setIdCompanyBusinessUnit($companyUser->getFkCompanyBusinessUnit())
            ->setIsActive(true);

        $companyUserCollectionTransfer = $this->collaborativeCartRepository
            ->getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer($companyUserCriteriaFilterTransfer);

        if ($companyUserCollectionTransfer->getCompanyUsers()->count() !== 1) {
            return null;
        }

        return $companyUserCollectionTransfer->getCompanyUsers()->offsetGet(0);
    }
}
