<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\AssignManufacturerUserToNonManufacturerCompaniesListener;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\UpdateNonManufacturerUsersCompanyRole;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CompanyUserCompanyAssignerEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
 /**
  * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
  *
  * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
  */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
            new AssignManufacturerUserToNonManufacturerCompaniesListener(),
        );

        $eventCollection->addListenerQueued(
            CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE,
            new UpdateNonManufacturerUsersCompanyRole(),
        );

        return $eventCollection;
    }
}
