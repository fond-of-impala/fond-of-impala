<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;

class CustomerByReferenceExpander implements ExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface
     */
    protected CompanyUsersBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface $repository
     */
    public function __construct(CompanyUsersBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer
     */
    public function expand(
        CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationCollectionTransfer
    ): CompanyUsersBulkPreparationCollectionTransfer {
        $customerCollection = $this->repository->findCustomerByReferences($this->resolveCustomerReferences($companyUsersBulkPreparationCollectionTransfer));
        $customer = [];
        foreach ($customerCollection->getCustomers() as $customerTransfer) {
            $customer[$customerTransfer->getCustomerReference()] = $customerTransfer;
        }

        foreach ($companyUsersBulkPreparationCollectionTransfer->getItems() as $preparedItem) {
            $customerReference = $preparedItem->getItem()->getCustomer()->getCustomerReference();
            if (array_key_exists($customerReference, $customer)) {
                $preparedItem->setCustomer($customer[$customerReference]);
            }
        }

        return $companyUsersBulkPreparationCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer
     *
     * @return array
     */
    protected function resolveCustomerReferences(CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer): array
    {
        $customerReferences = [];
        foreach ($companyUsersBulkPreparationTransfer->getItems() as $preparedItem) {
            if ($preparedItem->getCustomer() !== null) {
                continue;
            }

            $customerReference = $preparedItem->getItem()->getCustomer()->getCustomerReference();
            if ($customerReference !== null && $customerReference !== '') {
                $customerReferences[] = $customerReference;
            }
        }

        return $customerReferences;
    }
}
