<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Manager;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleManager implements CompanyRoleManagerInterface
{
    /**
     * @var string
     */
    protected const KEY_ID_COMPANY = 'id_company';

    /**
     * @var string
     */
    protected const KEY_ID_COMPANY_USER = 'id_company_user';

    protected CompanyUserReaderInterface $companyUserReader;

    protected CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade;

    protected CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade;

    protected CompanyUserCompanyAssignerConfig $config;

    protected CompanyUserCompanyAssignerRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig $config
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUserCompanyAssignerConfig $config,
        CompanyUserCompanyAssignerRepositoryInterface $repository
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->config = $config;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function updateCompanyRolesOfNonManufacturerUsers(CompanyUserTransfer $companyUserTransfer): void
    {
        $companyUserTransfer = $this->hydrateCompanyRoles($companyUserTransfer);

        $companyUsers = $this->companyUserReader->findWithInconsistentCompanyRolesByManufacturerUser(
            $companyUserTransfer,
        );

        if (count($companyUsers) === 0) {
            return;
        }

        $this->saveCompanyUsers($companyUsers, $companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function hydrateCompanyRoles(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer
    {
        foreach ($companyUserTransfer->getCompanyRoleCollection()->getRoles() as $companyRoleTransfer) {
            $transfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
            $companyRoleTransfer->fromArray($transfer->toArray(), true);
        }

        return $companyUserTransfer;
    }

    /**
     * @param array<int, array<string, mixed>> $companyUsers
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    protected function saveCompanyUsers(
        array $companyUsers,
        CompanyUserTransfer $manufacturerUserTransfer
    ): void {
        foreach ($companyUsers as $companyUser) {
            $updatableCompanyUserTransfer = (new CompanyUserTransfer())
                ->setIdCompanyUser($companyUser[static::KEY_ID_COMPANY_USER])
                ->setCompanyRoleCollection(
                    $this->createCompanyUserCompanyRoleCollection($manufacturerUserTransfer, $companyUser),
                );

            $this->companyRoleFacade->saveCompanyUser($updatableCompanyUserTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param array<string, mixed> $companyUser
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function createCompanyUserCompanyRoleCollection(
        CompanyUserTransfer $companyUserTransfer,
        array $companyUser
    ): CompanyRoleCollectionTransfer {
        $newCompanyRoleCollectionTransfer = new CompanyRoleCollectionTransfer();
        $companyRoleCollectionTransfer = $this->repository
            ->getCompanyRoleCollectionByCompanyId($companyUser[static::KEY_ID_COMPANY]);

        foreach ($companyUserTransfer->getCompanyRoleCollection()->getRoles() as $roleTransfer) {
            $idCompanyRole = $this->mapManufacturerCompanyRoleIdToCompanyRoleId(
                $roleTransfer,
                $companyRoleCollectionTransfer,
            );

            $companyRoleTransfer = (new CompanyRoleTransfer())
                ->setIdCompanyRole($idCompanyRole)
                ->setName($roleTransfer->getName())
                ->setFkCompany($companyUser[static::KEY_ID_COMPANY]);

            $newCompanyRoleCollectionTransfer->addRole($companyRoleTransfer);
        }

        return $newCompanyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $manufacturerCompanyRoleTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return int|null
     */
    protected function mapManufacturerCompanyRoleIdToCompanyRoleId(
        CompanyRoleTransfer $manufacturerCompanyRoleTransfer,
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
    ): ?int {
        $mapping = $this->config->getManufacturerCompanyTypeRoleMapping();
        $companyRoleName = $mapping[$manufacturerCompanyRoleTransfer->getName()] ?? $manufacturerCompanyRoleTransfer->getName();

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if ($companyRoleTransfer->getName() !== $companyRoleName) {
                continue;
            }

            return $companyRoleTransfer->getIdCompanyRole();
        }

        return null;
    }
}
