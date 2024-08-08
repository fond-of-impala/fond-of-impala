<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence;

use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideConfig;
use Generated\Shared\Transfer\CustomerCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence\OrderConfirmationRecipientsOverridePersistenceFactory getFactory()
 */
class OrderConfirmationRecipientsOverrideRepository extends AbstractRepository implements OrderConfirmationRecipientsOverrideRepositoryInterface
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
     * @return \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideConfig
     */
    protected function getConfig(): OrderConfirmationRecipientsOverrideConfig
    {
        /** @var \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideConfig $config */
        $config = $this->getFactory()->getConfig();

        return $config;
    }
}
