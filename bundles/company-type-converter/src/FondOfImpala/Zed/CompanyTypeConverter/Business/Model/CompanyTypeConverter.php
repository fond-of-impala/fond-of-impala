<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class CompanyTypeConverter implements CompanyTypeConverterInterface
{
    use TransactionTrait;

    protected CompanyTypeConverterPluginExecutorInterface $companyTypeConverterPluginExecutor;

    protected CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade;

    protected CompanyTypeConverterToCompanyRoleFacadeInterface $companyRoleFacade;

    protected CompanyTypeConverterToCompanyUserFacadeInterface $companyUserFacade;

    protected CompanyTypeConverterConfig $config;

    protected CompanyTypeRoleWriterInterface $companyTypeRoleWriter;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeRoleWriterInterface $companyTypeRoleWriter
     * @param \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig $config
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterPluginExecutorInterface $companyTypeConverterPluginExecutor
     */
    public function __construct(
        CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyTypeConverterToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeConverterToCompanyUserFacadeInterface $companyUserFacade,
        CompanyTypeRoleWriterInterface $companyTypeRoleWriter,
        CompanyTypeConverterConfig $config,
        CompanyTypeConverterPluginExecutorInterface $companyTypeConverterPluginExecutor
    ) {
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->companyTypeConverterPluginExecutor = $companyTypeConverterPluginExecutor;
        $this->companyTypeRoleWriter = $companyTypeRoleWriter;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function convertCompanyType(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(fn (): CompanyResponseTransfer => $this->executeConvertCompanyTypeTransaction($companyTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected function executeConvertCompanyTypeTransaction(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        $companyTransfer = $this->companyTypeConverterPluginExecutor
            ->executeCompanyTypeConverterPreSavePlugins($companyTransfer);

        $companyRoleCollectionTransfer = $this->companyTypeRoleWriter->updateCompanyRoles($companyTransfer);
        $companyUserCollectionTransfer = $this->companyUserFacade->getCompanyUserCollection(
            (new CompanyUserCriteriaFilterTransfer())->setIdCompany($companyTransfer->getIdCompany()),
        );

        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUserTransfer) {
            $this->assignDefaultCompanyRoleToCompanyUser(
                $companyUserTransfer,
                $companyTransfer,
                $companyRoleCollectionTransfer,
            );
        }

        $companyTransfer = $this->companyTypeConverterPluginExecutor
            ->executeCompanyTypeConverterPostSavePlugins($companyTransfer);

        return (new CompanyResponseTransfer())
            ->setIsSuccessful(true)
            ->setCompanyTransfer($companyTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return void
     */
    protected function assignDefaultCompanyRoleToCompanyUser(
        CompanyUserTransfer $companyUserTransfer,
        CompanyTransfer $companyTransfer,
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
    ): void {
        $companyTypeResponseTransfer = $this->companyTypeFacade->findCompanyTypeById(
            (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType()),
        );

        $companyUserCompanyRoleCollection = new CompanyRoleCollectionTransfer();
        foreach ($companyUserTransfer->getCompanyRoleCollection()->getRoles() as $companyRoleTransfer) {
            $defaultCompanyRoleTransfer = $this->getDefaultCompanyRoleFromCompanyRoleCollection(
                $companyRoleTransfer,
                $companyRoleCollectionTransfer,
                $companyTypeResponseTransfer->getCompanyTypeTransfer(),
            );

            if ($defaultCompanyRoleTransfer === null) {
                continue;
            }

            $companyUserCompanyRoleCollection->addRole($defaultCompanyRoleTransfer);
        }

        $companyUserTransfer->setCompanyRoleCollection($companyUserCompanyRoleCollection);
        $this->companyRoleFacade->saveCompanyUser($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $roleTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    protected function getDefaultCompanyRoleFromCompanyRoleCollection(
        CompanyRoleTransfer $roleTransfer,
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        CompanyTypeTransfer $companyTypeTransfer
    ): ?CompanyRoleTransfer {
        $companyTypeDefaultRoleMapping = $this->config
            ->getCompanyTypeDefaultRoleMapping($companyTypeTransfer->getName());

        if (isset($companyTypeDefaultRoleMapping[$roleTransfer->getName()]) === false) {
            return null;
        }

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if ($companyRoleTransfer->getName() === $companyTypeDefaultRoleMapping[$roleTransfer->getName()]) {
                return $companyRoleTransfer;
            }
        }

        return null;
    }
}
