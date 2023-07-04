<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Listener\CompanyUserDeleterListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CustomerAnonymizerCompanyUserConnectorEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER,
            new CompanyUserDeleterListener(),
        );

        return $eventCollection;
    }
}
