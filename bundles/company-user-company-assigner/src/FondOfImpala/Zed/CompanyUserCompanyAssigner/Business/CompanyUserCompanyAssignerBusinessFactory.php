<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssignerInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilter;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManager;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManagerInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapper;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapper;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyTypeReader;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyTypeReaderInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository getRepository()
 */
class CompanyUserCompanyAssignerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface
     */
    public function createCompanyUser(): CompanyUserInterface
    {
        return new CompanyUser(
            $this->getConfig(),
            $this->getRepository(),
            $this->getCompanyUserFacade(),
            $this->getCompanyFacade(),
            $this->getCompanyTypeFacade(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager\CompanyRoleManagerInterface
     */
    public function createCompanyRoleManager(): CompanyRoleManagerInterface
    {
        return new CompanyRoleManager(
            $this->createCompanyUserReader(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getConfig(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->createCompanyRoleNameMapper(),
            $this->getCompanyTypeFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyTypeReaderInterface
     */
    public function createCompanyTypeReader(): CompanyTypeReaderInterface
    {
        return new CompanyTypeReader($this->getCompanyTypeFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssignerInterface
     */
    public function createManufacturerUserAssigner(): ManufacturerUserAssignerInterface
    {
        return new ManufacturerUserAssigner(
            $this->createCompanyRoleNameMapper(),
            $this->createCompanyUserMapper(),
            $this->getRepository(),
            $this->getCompanyTypeFacade(),
            $this->getCompanyUserFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface
     */
    protected function createCompanyRoleNameMapper(): CompanyRoleNameMapperInterface
    {
        return new CompanyRoleNameMapper(
            $this->createCompanyRoleNameFilter(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface
     */
    protected function createCompanyRoleNameFilter(): CompanyRoleNameFilterInterface
    {
        return new CompanyRoleNameFilter(
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface
     */
    protected function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyUserCompanyAssignerToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUserCompanyAssignerToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_USER);
    }
}
