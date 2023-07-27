<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Shared\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConstants;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener\CompanyUsersBulkRestApiCompanyUserCreatorListener;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener\CompanyUsersBulkRestApiCompanyUserDeleterListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CompanyUsersBulkRestApiEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            CompanyUsersBulkRestApiConstants::BULK_UNASSIGN,
            new CompanyUsersBulkRestApiCompanyUserDeleterListener(),
        );

        $eventCollection->addListenerQueued(
            CompanyUsersBulkRestApiConstants::BULK_ASSIGN,
            new CompanyUsersBulkRestApiCompanyUserCreatorListener(),
        );

        return $eventCollection;
    }
}
