<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business;

use FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGenerator;
use FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGeneratorInterface;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReader;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReaderInterface;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReader;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReaderInterface;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceDependencyProvider;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface getRepository()
 */
class CompanyUserReferenceBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Business\Generator\CompanyUserReferenceGeneratorInterface
     */
    public function createCompanyUserReferenceGenerator(): CompanyUserReferenceGeneratorInterface
    {
        return new CompanyUserReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getStoreFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getRepository(),
            $this->getCompanyUserHydrationPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyReaderInterface
     */
    public function createCompanyReader(): CompanyReaderInterface
    {
        return new CompanyReader(
            $this->getRepository(),
            $this->getCompanyFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Business\Reader\CompanyBusinessUnitReaderInterface
     */
    public function createCompanyBusinessUnitReader(): CompanyBusinessUnitReaderInterface
    {
        return new CompanyBusinessUnitReader(
            $this->getRepository(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyUserReferenceToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyUserReferenceToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface
     */
    protected function getSequenceNumberFacade(): CompanyUserReferenceToSequenceNumberFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::FACADE_SEQUENCE_NUMBER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface
     */
    protected function getStoreFacade(): CompanyUserReferenceToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::FACADE_STORE);
    }

    /**
     * @return array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface>
     */
    protected function getCompanyUserHydrationPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserReferenceDependencyProvider::PLUGINS_COMPANY_USER_HYDRATE);
    }
}
