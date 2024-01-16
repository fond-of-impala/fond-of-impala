<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface
     */
    protected CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     */
    public function __construct(
        CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
    ) {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequest
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequest
    ): ?CompanyUserTransfer {
        $companyUserReference = $restCompanyUserCartsRequest->getCompanyUserReference();
        $idCustomer = $restCompanyUserCartsRequest->getIdCustomer();

        if ($companyUserReference === null || $idCustomer === null) {
            return null;
        }

        $companyUserTransfer = (new CompanyUserTransfer())
            ->setCompanyUserReference($companyUserReference);

        $companyUserResponseTransfer = $this->companyUserReferenceFacade->findCompanyUserByCompanyUserReference(
            $companyUserTransfer,
        );

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if (
            $companyUserTransfer === null
            || !$companyUserResponseTransfer->getIsSuccessful()
            || $companyUserTransfer->getFkCustomer() !== $idCustomer
        ) {
            return null;
        }

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequest
     *
     * @return int|null
     */
    public function getIdByRestCompanyUserCartsRequest(
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequest
    ): ?int {
        $companyUserReference = $restCompanyUserCartsRequest->getCompanyUserReference();
        $idCustomer = $restCompanyUserCartsRequest->getIdCustomer();

        if ($companyUserReference === null || $idCustomer === null) {
            return null;
        }

        return $this->companyUserReferenceFacade->getIdCompanyUserByCompanyUserReferenceAndIdCustomer(
            $companyUserReference,
            $idCustomer,
        );
    }
}
