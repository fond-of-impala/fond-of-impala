<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleExportValidator;

use ArrayObject;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;

class CompanyTypeRoleExportValidator implements CompanyTypeRoleExportValidatorInterface
{
    /**
     * @var string
     */
    protected const ENTITY_TRANSFER_FOREIGN_KEY_ID_COMPANY = 'spy_company_user.fk_company';

    /**
     * @var string
     */
    protected const ENTITY_TRANSFER_NAME_COMPANY_USER = 'spy_company_user';

    protected CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade;

    protected CompanyTypeRoleConfig $companyTypeRoleConfig;

    protected CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig $companyTypeRoleConfig
     */
    public function __construct(
        CompanyTypeRoleToCompanyUserFacadeInterface $companyUserFacade,
        CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyTypeRoleConfig $companyTypeRoleConfig
    ) {
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyTypeRoleConfig = $companyTypeRoleConfig;
        $this->companyUserFacade = $companyUserFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return bool
     */
    public function validate(EventEntityTransfer $eventEntityTransfer): bool
    {
        if ($eventEntityTransfer->getName() !== self::ENTITY_TRANSFER_NAME_COMPANY_USER) {
            return true;
        }

        $companyTypeTransfer = $this->getCompanyTypeTransfer($eventEntityTransfer);

        if (
            $companyTypeTransfer === null
            || $companyTypeTransfer->getName() === $this->companyTypeFacade->getCompanyTypeManufacturerName()
        ) {
                return false;
        }

        $companyUserTransfer = (new CompanyUserTransfer())->setIdCompanyUser($eventEntityTransfer->getId());
        $companyUserTransfer = $this->companyUserFacade->findCompanyUserById($companyUserTransfer);
        $companyUserRolesCollection = $this->getCompanyUserRolesCollection(
            $companyUserTransfer,
            $companyUserTransfer->getCompanyRoleCollection(),
        );

        return $this->isCompanyUserRollesCollectionValid($companyTypeTransfer, $companyUserRolesCollection);
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    protected function getCompanyTypeTransfer(EventEntityTransfer $eventEntityTransfer): ?CompanyTypeTransfer
    {
        $foreignKeys = $eventEntityTransfer->getForeignKeys();
        $idCompany = null;

        if (array_key_exists(self::ENTITY_TRANSFER_FOREIGN_KEY_ID_COMPANY, $foreignKeys)) {
            $idCompany = $foreignKeys[self::ENTITY_TRANSFER_FOREIGN_KEY_ID_COMPANY];
        }

        if ($idCompany === null) {
            return null;
        }

        $companyTransfer = (new CompanyTransfer())->setIdCompany($idCompany);

        return $this->companyTypeFacade->findCompanyTypeByIdCompany($companyTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected function getCompanyUserRolesCollection(
        CompanyUserTransfer $companyUserTransfer,
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
    ): ArrayObject {
        $companyUsersCollection = new ArrayObject();

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if (
                !$this->checkRoleHasCompanyUser(
                    $companyUserTransfer,
                    $companyRoleTransfer->getCompanyUserCollection()->getCompanyUsers(),
                )
            ) {
                continue;
            }

            $companyUsersCollection->append($companyRoleTransfer);
        }

        return $companyUsersCollection;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \ArrayObject<\Generated\Shared\Transfer\CompanyUserTransfer> $companyUsers
     *
     * @return bool
     */
    protected function checkRoleHasCompanyUser(
        CompanyUserTransfer $companyUserTransfer,
        ArrayObject $companyUsers
    ): bool {
        foreach ($companyUsers as $companyUser) {
            if ($companyUserTransfer->getIdCompanyUser() === $companyUser->getIdCompanyUser()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \ArrayObject<\Generated\Shared\Transfer\CompanyRoleTransfer> $companyRolleCollection
     *
     * @return bool
     */
    protected function isCompanyUserRollesCollectionValid(
        CompanyTypeTransfer $companyTypeTransfer,
        ArrayObject $companyRolleCollection
    ): bool {
        $companyRoles = $this->companyTypeRoleConfig->getValidCompanyRolesForExport($companyTypeTransfer->getName());

        /** @var \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer */
        foreach ($companyRolleCollection as $companyRoleTransfer) {
            if (!in_array($companyRoleTransfer->getName(), $companyRoles)) {
                return false;
            }
        }

        return true;
    }
}
