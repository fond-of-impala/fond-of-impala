<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Persistence;

use FondOfImpala\Zed\OrderConfirmationOverride\OrderConfirmationOverrideConfig;
use Generated\Shared\Transfer\CustomerCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\OrderConfirmationOverride\Persistence\OrderConfirmationOverridePersistenceFactory getFactory()
 */
class OrderConfirmationOverrideRepository extends AbstractRepository implements OrderConfirmationOverrideRepositoryInterface
{
    /**
     * @param array $emails
     *
     * @return \Generated\Shared\Transfer\CustomerCollectionTransfer
     */
    public function getAllowedCustomerCollectionByMails(array $emails): CustomerCollectionTransfer
    {
        $query = $this->getFactory()
            ->getCustomerQuery()
            ->clear();

        $protectedCompanyTypeIds = $this->getConfig()->getProtectedCompanyTypeIds();
        if (count($protectedCompanyTypeIds) > 0) {
            $query
                ->useCompanyUserQuery()
                    ->useCompanyQuery()
                        ->filterByFkCompanyType_In($protectedCompanyTypeIds)
                    ->endUse()
                ->endUse();
        }

        $collection = $query
            ->filterByEmail_In($emails)
            ->find();

        $customerCollection = new CustomerCollectionTransfer();
        /** @var \Orm\Zed\Customer\Persistence\SpyCustomer $customer */
        foreach ($collection->getData() as $customer) {
            $customerCollection->addCustomer((new CustomerTransfer())->fromArray($customer->toArray(), true));
        }

        return $customerCollection;
    }

    /**
     * @return \FondOfImpala\Zed\OrderConfirmationOverride\OrderConfirmationOverrideConfig
     */
    protected function getConfig(): OrderConfirmationOverrideConfig
    {
        /** @var \FondOfImpala\Zed\OrderConfirmationOverride\OrderConfirmationOverrideConfig $config */
        $config = $this->getFactory()->getConfig();

        return $config;
    }
}
