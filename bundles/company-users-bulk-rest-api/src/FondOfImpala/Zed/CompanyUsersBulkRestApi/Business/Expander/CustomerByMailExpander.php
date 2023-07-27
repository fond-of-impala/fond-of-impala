<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Expander;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;

class CustomerByMailExpander implements ExpanderInterface
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
        $customerCollection = $this->repository->findCustomerByEmail($this->resolveCustomerEmailAddresses($companyUsersBulkPreparationCollectionTransfer));
        $customer = [];
        foreach ($customerCollection->getCustomers() as $customerTransfer) {
            $customer[$customerTransfer->getEmail()] = $customerTransfer;
        }

        foreach ($companyUsersBulkPreparationCollectionTransfer->getItems() as $preparedItem) {
            $email = $preparedItem->getItem()->getCustomer()->getEmail();
            if (array_key_exists($email, $customer)) {
                $preparedItem->setCustomer($customer[$email]);
            }
        }

        return $companyUsersBulkPreparationCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer
     *
     * @return array
     */
    protected function resolveCustomerEmailAddresses(CompanyUsersBulkPreparationCollectionTransfer $companyUsersBulkPreparationTransfer): array
    {
        $customerEmailAddresses = [];
        foreach ($companyUsersBulkPreparationTransfer->getItems() as $preparedItem) {
            if ($preparedItem->getCustomer() !== null) {
                continue;
            }

            $customerEmail = $preparedItem->getItem()->getCustomer()->getEmail();
            if ($customerEmail !== null && $customerEmail !== '') {
                $customerEmailAddresses[] = $customerEmail;
            }
        }

        return $customerEmailAddresses;
    }
}
