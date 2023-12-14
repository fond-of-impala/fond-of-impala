<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business;

use FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator\CompanyTypeRoleExportValidator;
use FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator\CompanyTypeRoleExportValidatorInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGenerator;
use FondOfImpala\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersection;
use FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapper;
use FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssigner;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\PermissionReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Model\PermissionReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\PermissionReader as NewPermissionReader;
use FondOfImpala\Zed\CompanyTypeRole\Business\Reader\PermissionReaderInterface as NewPermissionReaderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizer;
use FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizerInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizer;
use FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizerInterface;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleDependencyProvider;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface getRepository()
 */
class CompanyTypeRoleBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Model\CompanyRoleAssignerInterface
     */
    public function createCompanyRoleAssigner(): CompanyRoleAssignerInterface
    {
        return new CompanyRoleAssigner(
            $this->getConfig(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Model\PermissionReaderInterface
     */
    public function createPermissionReader(): PermissionReaderInterface
    {
        return new PermissionReader($this->getConfig());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator\CompanyTypeRoleExportValidatorInterface
     */
    public function createCompanyTypeRoleExportValidator(): CompanyTypeRoleExportValidatorInterface
    {
        return new CompanyTypeRoleExportValidator(
            $this->getCompanyUserFacade(),
            $this->getCompanyTypeFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\PermissionSynchronizerInterface
     */
    public function createPermissionSynchronizer(): PermissionSynchronizerInterface
    {
        return new PermissionSynchronizer(
            $this->createCompanyRoleReader(),
            $this->getCompanyRoleFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyRoleReaderInterface
     */
    protected function createCompanyRoleReader(): CompanyRoleReaderInterface
    {
        return new CompanyRoleReader(
            $this->createNewPermissionReader(),
            $this->createPermissionKeyMapper(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\PermissionReaderInterface
     */
    protected function createNewPermissionReader(): NewPermissionReaderInterface
    {
        return new NewPermissionReader(
            $this->createPermissionIntersection(),
            $this->getConfig(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Mapper\PermissionKeyMapperInterface
     */
    protected function createPermissionKeyMapper(): PermissionKeyMapperInterface
    {
        return new PermissionKeyMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer\CompanyRoleSynchronizerInterface
     */
    public function createCompanyRoleSynchronizer(): CompanyRoleSynchronizerInterface
    {
        return new CompanyRoleSynchronizer(
            $this->getCompanyFacade(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\AssignableCompanyRoleReaderInterface
     */
    public function createAssignableCompanyRoleReader(): AssignableCompanyRoleReaderInterface
    {
        return new AssignableCompanyRoleReader(
            $this->createAssignPermissionKeyGenerator(),
            $this->createCompanyUserReader(),
            $this->getCompanyRoleFacade(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Generator\AssignPermissionKeyGeneratorInterface
     */
    protected function createAssignPermissionKeyGenerator(): AssignPermissionKeyGeneratorInterface
    {
        return new AssignPermissionKeyGenerator();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Reader\CompanyUserReaderInterface
     */
    protected function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getCompanyUserFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface
     */
    protected function createPermissionIntersection(): PermissionIntersectionInterface
    {
        return new PermissionIntersection();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyTypeRoleToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_USER);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyTypeRoleToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyTypeRoleToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyTypeRoleToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyTypeRoleToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeRoleDependencyProvider::FACADE_PERMISSION);
    }
}
