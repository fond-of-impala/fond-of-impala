<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyUserCompanyAssignerCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface
     */
    public function getEventFacade(): CompanyUserCompanyAssignerToEventFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_EVENT);
    }
}
