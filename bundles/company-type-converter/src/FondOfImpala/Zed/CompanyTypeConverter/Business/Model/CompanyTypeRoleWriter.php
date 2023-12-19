<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use FondOfImpala\Zed\CompanyTypeConverter\Business\Exception\CompanyRoleCouldNotBeCreatedException;
use FondOfImpala\Zed\CompanyTypeConverter\Business\Exception\CompanyRoleCouldNotBeDeletedException;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class CompanyTypeRoleWriter implements CompanyTypeRoleWriterInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface
     */
    protected $companyTypeRoleFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig
     */
    protected $config;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeRoleFacadeInterface $companyTypeRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToPermissionFacadeInterface $permissionFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig $config
     */
    public function __construct(
        CompanyTypeConverterToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyTypeConverterToCompanyTypeRoleFacadeInterface $companyTypeRoleFacade,
        CompanyTypeConverterToPermissionFacadeInterface $permissionFacade,
        CompanyTypeConverterConfig $config
    ) {
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyTypeRoleFacade = $companyTypeRoleFacade;
        $this->permissionFacade = $permissionFacade;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function updateCompanyRoles(CompanyTransfer $companyTransfer): CompanyRoleCollectionTransfer
    {
        $companyRoleCollectionTransfer = $this->saveCompanyRoles($companyTransfer);
        $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
        $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $this->saveCompanyRolePermissions($companyTypeResponseTransfer->getCompanyTypeTransfer(), $companyRoleTransfer);
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @throws \FondOfImpala\Zed\CompanyTypeConverter\Business\Exception\CompanyRoleCouldNotBeCreatedException
     * @throws \FondOfImpala\Zed\CompanyTypeConverter\Business\Exception\CompanyRoleCouldNotBeDeletedException
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function saveCompanyRoles(CompanyTransfer $companyTransfer): CompanyRoleCollectionTransfer
    {
        $companyRoleCriteriaFilterTransfer = (new CompanyRoleCriteriaFilterTransfer())
            ->setIdCompany($companyTransfer->getIdCompany());
        $companyRoleCollection = $this->companyRoleFacade
            ->getCompanyRoleCollection($companyRoleCriteriaFilterTransfer);

        $currentCompanyRoleNames = $this->getCurrentCompanyRoleNames($companyRoleCollection);
        $requestedCompanyRoleNames = $this->getRequestedCompanyRoleNames($companyTransfer);

        $saveCompanyRoles = array_diff($requestedCompanyRoleNames, $currentCompanyRoleNames);
        $deleteCompanyRoles = array_diff($currentCompanyRoleNames, $requestedCompanyRoleNames);

        if (count($saveCompanyRoles) > 0) {
            foreach ($saveCompanyRoles as $companyRole) {
                $companyRoleResponseTransfer = $this->createCompanyRole($companyTransfer, $companyRole);

                if ($companyRoleResponseTransfer->getIsSuccessful() === false) {
                    throw new CompanyRoleCouldNotBeCreatedException('Company Role Could not be created');
                }

                $companyRoleCollection->addRole($companyRoleResponseTransfer->getCompanyRoleTransfer());
            }
        }

        if (count($deleteCompanyRoles) > 0) {
            foreach ($deleteCompanyRoles as $companyRole) {
                $companyRoleResponseTransfer = $this->deleteCompanyRole($companyRoleCollection, $companyRole);

                if (
                    $companyRoleResponseTransfer === null
                    || $companyRoleResponseTransfer->getIsSuccessful() === false
                ) {
                    throw new CompanyRoleCouldNotBeDeletedException('Company Role could not be deleted');
                }
            }
        }

        return $companyRoleCollection;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param string $companyName
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected function createCompanyRole(
        CompanyTransfer $companyTransfer,
        string $companyName
    ): CompanyRoleResponseTransfer {
        $companyRoleTransfer = (new CompanyRoleTransfer())
            ->setName($companyName)
            ->setFkCompany($companyTransfer->getIdCompany());

        return $this->companyRoleFacade->create($companyRoleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param string $companyRoleName
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer|null
     */
    protected function deleteCompanyRole(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        string $companyRoleName
    ): ?CompanyRoleResponseTransfer {
        foreach ($companyRoleCollectionTransfer->getRoles() as $roleTransfer) {
            if ($roleTransfer->getName() !== $companyRoleName) {
                continue;
            }
            $companyRoleTransfer = (new CompanyRoleTransfer())
                ->setIdCompanyRole($roleTransfer->getIdCompanyRole());

            return $this->companyTypeRoleFacade->deleteCompanyRoleAndCompanyUserByCompanyRole($companyRoleTransfer);
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return array<string>
     */
    protected function getCurrentCompanyRoleNames(CompanyRoleCollectionTransfer $companyRoleCollectionTransfer): array
    {
        $companyRoleNames = [];

        foreach ($companyRoleCollectionTransfer->getRoles() as $roleTransfer) {
            $companyRoleNames[] = $roleTransfer->getName();
        }

        return $companyRoleNames;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return array<string>
     */
    protected function getRequestedCompanyRoleNames(CompanyTransfer $companyTransfer): array
    {
        $companyRoleNames = [];
        $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
        $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);

        if ($companyTypeResponseTransfer->getIsSuccessful() === false) {
            return $companyRoleNames;
        }

        $companyTypeDefaultRoleMapping = $this->config
            ->getCompanyTypeDefaultRoleMapping($companyTypeResponseTransfer->getCompanyTypeTransfer()->getName());

        foreach ($companyTypeDefaultRoleMapping as $roleName => $defaultRoleName) {
            $companyRoleNames[] = $roleName;
        }

        return $companyRoleNames;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return void
     */
    protected function saveCompanyRolePermissions(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): void {
        $permissionKeys = $this->companyTypeRoleFacade
            ->getPermissionKeysByCompanyTypeAndCompanyRole($companyTypeTransfer, $companyRoleTransfer);
        $availablePermissionCollectionTransfer = $this->permissionFacade
            ->findMergedRegisteredNonInfrastructuralPermissions();

        $permissionCollection = (new PermissionCollectionTransfer());
        foreach ($availablePermissionCollectionTransfer->getPermissions() as $permissionTransfer) {
            if (in_array($permissionTransfer->getKey(), $permissionKeys) === false) {
                continue;
            }

            $permissionCollection->addPermission(
                (new PermissionTransfer())
                    ->setKey($permissionTransfer->getKey())
                    ->setIdPermission($permissionTransfer->getIdPermission()),
            );
        }

        $this->companyRoleFacade->update(
            $companyRoleTransfer->setPermissionCollection($permissionCollection),
        );
    }
}
