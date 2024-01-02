<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Model;

use ArrayObject;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

class CompanyUser implements CompanyUserInterface
{
    protected CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade;

    protected CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade;

    protected CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade;

    protected CompanyUserCompanyAssignerConfig $companyUserCompanyAssignerConfig;

    protected CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade;

    protected CompanyUserCompanyAssignerRepositoryInterface $companyUserCompanyAssignerRepository;

    protected CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig $companyUserCompanyAssignerConfig
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $companyUserCompanyAssignerRepository
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     */
    public function __construct(
        CompanyUserCompanyAssignerConfig $companyUserCompanyAssignerConfig,
        CompanyUserCompanyAssignerRepositoryInterface $companyUserCompanyAssignerRepository,
        CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
    ) {
        $this->companyFacade = $companyFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyUserCompanyAssignerConfig = $companyUserCompanyAssignerConfig;
        $this->companyUserFacade = $companyUserFacade;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserCompanyAssignerRepository = $companyUserCompanyAssignerRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function addManufacturerUserToCompanies(
        CompanyUserResponseTransfer $companyUserResponseTransfer
    ): CompanyUserResponseTransfer {
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $companyUserTransfer->getFkCompany() === null) {
            return $companyUserResponseTransfer;
        }

        $companyTransfer = $this->companyFacade->findCompanyById($companyUserTransfer->getFkCompany());

        if ($companyTransfer === null) {
            return $companyUserResponseTransfer;
        }
        $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
        $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);

        if (
            $companyTypeResponseTransfer->getIsSuccessful() === false
            || $companyTypeResponseTransfer->getCompanyTypeTransfer() === null
        ) {
            return $companyUserResponseTransfer;
        }

        if (
            $this->isCompanyTypeManufacturer(
                $companyTypeResponseTransfer->getCompanyTypeTransfer(),
            ) === false
        ) {
            return $companyUserResponseTransfer;
        }

        $companyTypeCollectionTransfer = $this->companyTypeFacade->getCompanyTypes();
        $companyTypeCollectionTransfer = $this->getNoneManufacturerIdCompanyTypes($companyTypeCollectionTransfer);
        $companyCollectionTransfer = $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);

        if ($companyCollectionTransfer === null) {
            return $companyUserResponseTransfer;
        }

        foreach ($companyCollectionTransfer->getCompanies() as $noneManufacturerCompanyTransfer) {
            if ($companyUserTransfer->getCompanyRoleCollection() === null) {
                continue;
            }

            $this->createAndAssignCompanyUser(
                $noneManufacturerCompanyTransfer,
                $companyUserTransfer,
                $companyUserTransfer->getCompanyRoleCollection()->getRoles(),
            );
        }

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function addManufacturerUsersToCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();
        $companyTypeTransfer = $companyTransfer->getCompanyType();

        if ($companyTypeTransfer === null) {
            $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
        }

        $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);

        if (
            $companyTypeResponseTransfer->getIsSuccessful() === false
            || $companyTypeResponseTransfer->getCompanyTypeTransfer() === null
        ) {
            return $companyResponseTransfer;
        }

        $companyCollectionTransfer = $this->getCompanyCollectionByCompanyTypeName(
            $this->companyTypeFacade->getCompanyTypeManufacturerName(),
        );

        if ($companyCollectionTransfer === null) {
            return $companyResponseTransfer;
        }

        foreach ($companyCollectionTransfer->getCompanies() as $manufacturerCompanyTransfer) {
            $manufacturerCompanyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
                ->setIdCompany($manufacturerCompanyTransfer->getIdCompany());
            $manufacturerCompanyUserCollectionTransfer = $this->companyUserFacade
                ->getCompanyUserCollection($manufacturerCompanyUserCriteriaFilterTransfer);

            foreach ($manufacturerCompanyUserCollectionTransfer->getCompanyUsers() as $manufacturerCompanyUserTransfer) {
                if ($manufacturerCompanyUserTransfer->getCompanyRoleCollection() === null) {
                    continue;
                }

                $this->createAndAssignCompanyUser(
                    $companyTransfer,
                    $manufacturerCompanyUserTransfer,
                    $manufacturerCompanyUserTransfer->getCompanyRoleCollection()->getRoles(),
                );
            }
        }

        return $companyResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function addManufacturerUsersToCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer {
        $companyTransfer = $this->mapCompanyBusinessUnitTransferToCompanyTransfer($companyBusinessUnitTransfer);

        $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
        $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);

        if (
            $companyTypeResponseTransfer->getIsSuccessful() === false
            || $companyTypeResponseTransfer->getCompanyTypeTransfer() === null
        ) {
            return $companyBusinessUnitTransfer;
        }

        if (
            $this->isCompanyTypeManufacturer($companyTypeResponseTransfer->getCompanyTypeTransfer()) === true
        ) {
            return $companyBusinessUnitTransfer;
        }

        $manufacturerCompanyCollectionTransfer = $this->getCompanyCollectionByCompanyTypeName(
            $this->companyTypeFacade->getCompanyTypeManufacturerName(),
        );

        if ($manufacturerCompanyCollectionTransfer === null) {
            return $companyBusinessUnitTransfer;
        }

        foreach ($manufacturerCompanyCollectionTransfer->getCompanies() as $manufacturerCompanyTransfer) {
            $manufacturerCompanyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
                ->setIdCompany($manufacturerCompanyTransfer->getIdCompany());

            $manufacturerCompanyUserCollectionTransfer = $this->companyUserFacade->getCompanyUserCollection(
                $manufacturerCompanyUserCriteriaFilterTransfer,
            );

            foreach ($manufacturerCompanyUserCollectionTransfer->getCompanyUsers() as $manufacturerCompanyUserTransfer) {
                if ($this->hasCompanyCompanyUser($companyTransfer, $manufacturerCompanyUserTransfer)) {
                    continue;
                }

                if ($manufacturerCompanyUserTransfer->getCompanyRoleCollection() === null) {
                    continue;
                }

                $this->createAndAssignCompanyUser(
                    $companyTransfer,
                    $manufacturerCompanyUserTransfer,
                    $manufacturerCompanyUserTransfer->getCompanyRoleCollection()->getRoles(),
                );
            }
        }

        return $companyBusinessUnitTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    protected function getNoneManufacturerIdCompanyTypes(
        CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
    ): CompanyTypeCollectionTransfer {
        $noneManufacturerCompanyTypeCollectionTransfer = new CompanyTypeCollectionTransfer();
        foreach ($companyTypeCollectionTransfer->getCompanyTypes() as $companyTypeTransfer) {
            if ($this->isCompanyTypeManufacturer($companyTypeTransfer) === false) {
                $noneManufacturerCompanyTypeCollectionTransfer->addCompanyType($companyTypeTransfer);
            }
        }

        return $noneManufacturerCompanyTypeCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \ArrayObject<\Generated\Shared\Transfer\CompanyRoleTransfer> $companyRoleTransfers
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected function createAndAssignCompanyUser(
        CompanyTransfer $companyTransfer,
        CompanyUserTransfer $companyUserTransfer,
        ArrayObject $companyRoleTransfers
    ): CompanyUserResponseTransfer {
        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId(
            $companyTransfer->getIdCompany(),
        );

        $companyRoleCollectionTransfer = $this->createCompanyRoleCollectionTransfer(
            $companyTransfer,
            $companyRoleTransfers,
        );

        if ($companyRoleCollectionTransfer->getRoles()->count() === 0) {
            return (new CompanyUserResponseTransfer())
                ->setIsSuccessful(false);
        }

        $newCompanyUserTransfer = (new CompanyUserTransfer())
            ->setCustomer($companyUserTransfer->getCustomer())
            ->setFkCustomer($companyUserTransfer->getFkCustomer())
            ->setFkCompany($companyTransfer->getIdCompany())
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit())
            ->setCompanyRoleCollection($companyRoleCollectionTransfer);

        return $this->companyUserFacade->create($newCompanyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \ArrayObject<\Generated\Shared\Transfer\CompanyRoleTransfer> $companyRoleTransfers
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function createCompanyRoleCollectionTransfer(
        CompanyTransfer $companyTransfer,
        ArrayObject $companyRoleTransfers
    ): CompanyRoleCollectionTransfer {
        $companyRoleCollectionTransfer = (new CompanyRoleCollectionTransfer());

        foreach ($companyRoleTransfers as $companyRoleTransfer) {
            $companyRoleTransfer = $this->findCompanyRoleTransferByIdCompanyAndName(
                $companyTransfer,
                $companyRoleTransfer,
            );

            if ($companyRoleTransfer === null) {
                continue;
            }

            $companyRoleCollectionTransfer->addRole($companyRoleTransfer);
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    protected function findCompanyRoleTransferByIdCompanyAndName(
        CompanyTransfer $companyTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): ?CompanyRoleTransfer {
        $companyRoleTransfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
        $manufacturerCompanyTypeRoleMapping = $this->companyUserCompanyAssignerConfig
            ->getManufacturerCompanyTypeRoleMapping();

        if (!isset($manufacturerCompanyTypeRoleMapping[$companyRoleTransfer->getName()])) {
            return null;
        }

        return $this->companyUserCompanyAssignerRepository->findCompanyRoleTransferByIdCompanyAndCompanyRoleName(
            $companyTransfer->getIdCompany(),
            $manufacturerCompanyTypeRoleMapping[$companyRoleTransfer->getName()],
        );
    }

    /**
     * @param string $companyTypeName
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    protected function getCompanyCollectionByCompanyTypeName(string $companyTypeName): ?CompanyCollectionTransfer
    {
        $companyTypeTransfer = (new CompanyTypeTransfer())->setName($companyTypeName);
        $companyTypeTransfer = $this->companyTypeFacade->getCompanyTypeByName($companyTypeTransfer);

        if ($companyTypeTransfer === null) {
            return null;
        }

        $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTypeTransfer->getIdCompanyType());
        $companyTypeCollectionTransfer = (new CompanyTypeCollectionTransfer())->addCompanyType($companyTypeTransfer);

        return $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    protected function mapCompanyBusinessUnitTransferToCompanyTransfer(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyTransfer {
        if ($companyBusinessUnitTransfer->getFkCompany() !== null) {
            return $this->companyFacade->findCompanyById($companyBusinessUnitTransfer->getFkCompany());
        }

        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade->findCompanyBusinessUnitById(
            $companyBusinessUnitTransfer->getIdCompanyBusinessUnit(),
        );

        return $this->companyFacade->findCompanyById($companyBusinessUnitTransfer->getFkCompany());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return bool
     */
    protected function isCompanyTypeManufacturer(CompanyTypeTransfer $companyTypeTransfer): bool
    {
        return $companyTypeTransfer->getName() === $this->companyTypeFacade->getCompanyTypeManufacturerName();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function hasCompanyCompanyUser(
        CompanyTransfer $companyTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): bool {
        $customerTransfer = (new CustomerTransfer())->setIdCustomer($companyUserTransfer->getFkCustomer());

        return $this->companyUserCompanyAssignerRepository->findCompanyUserByIdCompanyAndIdCustomer(
            $companyTransfer,
            $customerTransfer,
        ) !== null;
    }
}
