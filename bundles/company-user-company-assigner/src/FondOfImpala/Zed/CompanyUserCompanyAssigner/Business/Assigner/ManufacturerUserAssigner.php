<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;

class ManufacturerUserAssigner implements ManufacturerUserAssignerInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface
     */
    protected $companyRoleNameMapper;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $config;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface
     */
    protected $companyUserMapper;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface $companyRoleNameMapper
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface $companyUserMapper
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig $config
     */
    public function __construct(
        CompanyRoleNameMapperInterface $companyRoleNameMapper,
        CompanyUserMapperInterface $companyUserMapper,
        CompanyUserCompanyAssignerRepositoryInterface $repository,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserCompanyAssignerConfig $config
    ) {
        $this->companyRoleNameMapper = $companyRoleNameMapper;
        $this->companyUserMapper = $companyUserMapper;
        $this->repository = $repository;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    public function assignToNonManufacturerCompanies(CompanyUserTransfer $manufacturerUserTransfer): void
    {
        $idCompanyUser = $manufacturerUserTransfer->getIdCompanyUser();
        $idCustomer = $manufacturerUserTransfer->getFkCustomer();

        if ($idCompanyUser === null || $idCustomer === null) {
            return;
        }

        $companyTypeName = $this->repository->findCompanyTypeNameByIdCompanyUser($idCompanyUser);
        $companyTypeNameForManufacturer = $this->companyTypeFacade->getCompanyTypeManufacturerName();

        if ($companyTypeName !== $companyTypeNameForManufacturer) {
            return;
        }

        $companyRoleName = $this->companyRoleNameMapper->fromManufacturerUser($manufacturerUserTransfer);

        if ($companyRoleName === null || !$this->isValidCompanyRole($companyRoleName)) {
            return;
        }

        $nonManufacturerData = $this->repository->findNonManufacturerData($companyTypeNameForManufacturer, $companyRoleName);
        $companyUserTransfers = $this->companyUserMapper->fromNonManufacturerData($nonManufacturerData);

        foreach ($companyUserTransfers as $companyUserTransfer) {
            $companyUserTransfer = $companyUserTransfer->setFkCustomer($idCustomer)
                ->setCustomer($manufacturerUserTransfer->getCustomer());

            $this->companyUserFacade->create($companyUserTransfer);
        }
    }

    /**
     * @param string $companyRoleName
     *
     * @return bool
     */
    protected function isValidCompanyRole(string $companyRoleName): bool
    {
        if (!in_array($companyRoleName, $this->config->getValidManufacturerCompanyRolesForAssignment())) {
            return false;
        }

        return true;
    }
}
