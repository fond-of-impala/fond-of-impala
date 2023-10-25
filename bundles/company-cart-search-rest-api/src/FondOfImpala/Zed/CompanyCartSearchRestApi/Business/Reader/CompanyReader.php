<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface;
use FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface;

class CompanyReader implements CompanyReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface
     */
    protected IdCustomerFilterInterface $idCustomerFilter;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface
     */
    protected CompanyUuidFilterInterface $companyUuidFilter;

    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface
     */
    protected CompanyCartSearchRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\IdCustomerFilterInterface $idCustomerFilter
     * @param \FondOfImpala\Zed\CompanyCartSearchRestApi\Business\Filter\CompanyUuidFilterInterface $companyUuidFilter
     * @param \FondOfImpala\Zed\CompanyCartSearchRestApi\Persistence\CompanyCartSearchRestApiRepositoryInterface $repository
     */
    public function __construct(
        IdCustomerFilterInterface $idCustomerFilter,
        CompanyUuidFilterInterface $companyUuidFilter,
        CompanyCartSearchRestApiRepositoryInterface $repository
    ) {
        $this->idCustomerFilter = $idCustomerFilter;
        $this->companyUuidFilter = $companyUuidFilter;
        $this->repository = $repository;
    }

    /**
     * @param array $filterFieldTransfers
     *
     * @return int|null
     */
    public function getIdByFilterFields(array $filterFieldTransfers): ?int
    {
        $idCustomer = null;
        $companyUuid = null;

        foreach ($filterFieldTransfers as $fieldTransfer) {
            if ($idCustomer === null) {
                $idCustomer = $this->idCustomerFilter->filterByFilterField($fieldTransfer);

                continue;
            }

            if ($companyUuid === null) {
                $companyUuid = $this->companyUuidFilter->filterByFilterField($fieldTransfer);
            }
        }

        if ($idCustomer === null || $companyUuid === null) {
            return null;
        }

        return $this->repository->getIdCompanyByIdCustomerAndCompanyUuid(
            $idCustomer,
            $companyUuid,
        );
    }
}
