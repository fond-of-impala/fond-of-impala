<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer;

use ArrayObject;
use Exception;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface;
use Generated\Shared\Transfer\CompanyCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\FilterTransfer;

class CompanyRoleSynchronizer implements CompanyRoleSynchronizerInterface
{
    protected CompanyTypeRoleToCompanyFacadeInterface $companyFacade;

    protected CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade;

    protected CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade;

    protected CompanyTypeRoleRepositoryInterface $repository;

    protected CompanyTypeRoleConfig $config;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeInterface $companyFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig $config
     */
    public function __construct(
        CompanyTypeRoleToCompanyFacadeInterface $companyFacade,
        CompanyTypeRoleRepositoryInterface $repository,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyTypeRoleConfig $config
    ) {
        $this->companyFacade = $companyFacade;
        $this->repository = $repository;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function sync(): void
    {
        $companyCount = $this->repository->getCompanyCount();

        if ($companyCount === 0) {
            return;
        }

        $offset = 0;
        $limit = $this->config->getCompanySyncChunkSize();
        while ($companyCount > $offset) {
            $filter = (new FilterTransfer())->setLimit($limit)->setOffset($offset);
            $companyCriteriaFilterTransfer = (new CompanyCriteriaFilterTransfer())->setFilter($filter);
            $companyCollectionTransfer = $this->companyFacade->getCompanyCollection($companyCriteriaFilterTransfer);

            foreach ($companyCollectionTransfer->getCompanies() as $companyTransfer) {
                $companyRoleCollectionTransfer = $this->getCompanyRoleCollection($companyTransfer);

                $this->setCompanyRoles($companyTransfer, $companyRoleCollectionTransfer);
            }
            unset($companyCollectionTransfer);
            $offset += $limit;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function getCompanyRoleCollection(CompanyTransfer $companyTransfer): CompanyRoleCollectionTransfer
    {
        return $this->companyRoleFacade->getCompanyRoleCollection(
            (new CompanyRoleCriteriaFilterTransfer())->setIdCompany($companyTransfer->getIdCompany()),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $currentCompanyRoleCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function setCompanyRoles(
        CompanyTransfer $companyTransfer,
        CompanyRoleCollectionTransfer $currentCompanyRoleCollectionTransfer
    ): CompanyRoleCollectionTransfer {
        $companyType = $this->companyTypeFacade->findCompanyTypeByIdCompany($companyTransfer);
        $configCompanyRoles = $this->getConfigCompanyRoles($companyType->getName());

        $companyRoleCollectionTransfer = $this->removeCompanyRoles(
            $currentCompanyRoleCollectionTransfer,
            $configCompanyRoles,
        );

        $companyRoleCollectionTransfer = $this->addCompanyRoles(
            $companyTransfer,
            $companyRoleCollectionTransfer,
            $configCompanyRoles,
        );

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param array<string> $configCompanyRoles
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function removeCompanyRoles(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        array $configCompanyRoles
    ): CompanyRoleCollectionTransfer {
        $companyRoles = $this->getDeletedCompanyRoles($companyRoleCollectionTransfer, $configCompanyRoles);

        if (!$companyRoles->count()) {
            return $companyRoleCollectionTransfer;
        }

        foreach ($companyRoles as $companyRoleTransfer) {
            $companyRoleResponseTransfer = $this->companyRoleFacade->delete($companyRoleTransfer);
            if ($companyRoleResponseTransfer->getIsSuccessful() === false) {
                throw new Exception(
                    sprintf(
                        'Could not delete Company Role "%s" for the Company "%s", because %s.',
                        $companyRoleResponseTransfer->getCompanyRoleTransfer()->getName(),
                        $companyRoleResponseTransfer->getCompanyRoleTransfer()->getFkCompany(),
                        $companyRoleResponseTransfer->getMessages()->offsetGet(0)->getText(),
                    ),
                );
            }

            $companyRoleCollectionTransfer = $this->removeCompanyRoleFromCollectionByName(
                $companyRoleCollectionTransfer,
                $companyRoleTransfer->getName(),
            );
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function removeCompanyRoleFromCollectionByName(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        string $name
    ): CompanyRoleCollectionTransfer {
        foreach ($companyRoleCollectionTransfer->getRoles() as $index => $companyRoleTransfer) {
            if ($companyRoleTransfer->getName() !== $name) {
                continue;
            }

            $companyRoleCollectionTransfer->getRoles()->offsetUnset($index);
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param array<string> $configCompanyRoles
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function addCompanyRoles(
        CompanyTransfer $companyTransfer,
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        array $configCompanyRoles
    ): CompanyRoleCollectionTransfer {
        $companyRoles = $this->getNewCompanyRoles(
            $companyTransfer,
            $companyRoleCollectionTransfer,
            $configCompanyRoles,
        );

        if (!$companyRoles->count()) {
            return $companyRoleCollectionTransfer;
        }

        foreach ($companyRoles as $companyRoleTransfer) {
            $companyRoleResponseTransfer = $this->companyRoleFacade->create($companyRoleTransfer);

            if ($companyRoleResponseTransfer->getIsSuccessful() === false) {
                throw new Exception(
                    sprintf(
                        'Could not add Company Role "%s" for the Company "%s", because %s.',
                        $companyRoleResponseTransfer->getCompanyRoleTransfer()->getName(),
                        $companyRoleResponseTransfer->getCompanyRoleTransfer()->getFkCompany(),
                        $companyRoleResponseTransfer->getMessages()->offsetGet(0)->getText(),
                    ),
                );
            }

            $companyRoleCollectionTransfer->getRoles()->append($companyRoleResponseTransfer->getCompanyRoleTransfer());
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param array<string> $configCompanyRoles
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected function getDeletedCompanyRoles(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        array $configCompanyRoles
    ): ArrayObject {
        $deleteCompanyRoles = new ArrayObject();

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if (!in_array($companyRoleTransfer->getName(), $configCompanyRoles)) {
                $deleteCompanyRoles->append($companyRoleTransfer);
            }
        }

        return $deleteCompanyRoles;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $currentCompanyRoleCollectionTransfer
     * @param array<string> $configCompanyRoles
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected function getNewCompanyRoles(
        CompanyTransfer $companyTransfer,
        CompanyRoleCollectionTransfer $currentCompanyRoleCollectionTransfer,
        array $configCompanyRoles
    ): ArrayObject {
        $companyRoleCollectionTransfer = new ArrayObject();
        $currentCompanyRoles = [];

        foreach ($currentCompanyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $currentCompanyRoles[] = $companyRoleTransfer->getName();
        }

        $newCompanyRoles = array_diff($configCompanyRoles, $currentCompanyRoles);

        foreach ($newCompanyRoles as $companyRole) {
            $companyRoleCollectionTransfer->append((new CompanyRoleTransfer())
                ->setFkCompany($companyTransfer->getIdCompany())
                ->setName($companyRole));
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param string $name
     *
     * @return array<string>
     */
    protected function getConfigCompanyRoles(string $name): array
    {
        $roles = [];
        $companyRoles = $this->config->getPredefinedCompanyRolesByCompanyTypeName($name);

        foreach ($companyRoles as $companyRoleTransfer) {
            $roles[] = $companyRoleTransfer->getName();
        }

        return $roles;
    }
}
