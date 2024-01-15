<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ResponseMessageTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var string
     */
    protected const MESSAGE_COMPANY_USER_NOT_FOUND = 'message.company_user.not_found';

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface
     */
    protected $repository;

    /**
     * @var array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface>
     */
    protected $companyUserHydrationPlugins;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface $repository
     * @param array<\Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserHydrationPluginInterface> $companyUserHydrationPlugins
     */
    public function __construct(
        CompanyUserReferenceRepositoryInterface $repository,
        array $companyUserHydrationPlugins
    ) {
        $this->repository = $repository;
        $this->companyUserHydrationPlugins = $companyUserHydrationPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByCompanyUserReference(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserResponseTransfer {
        $companyUserTransfer = $this->repository->findCompanyUserByCompanyUserReference(
            $companyUserTransfer->getCompanyUserReference(),
        );

        $companyUserResponseTransfer = new CompanyUserResponseTransfer();

        $companyUserResponseTransfer->setIsSuccessful(true)
            ->setCompanyUser($companyUserTransfer);

        if ($companyUserTransfer !== null) {
            $companyUserTransfer = $this->executeCompanyUserHydrationPlugins($companyUserTransfer);
            $companyUserResponseTransfer->setCompanyUser($companyUserTransfer);

            return $companyUserResponseTransfer;
        }

        $companyUserResponseTransfer->setIsSuccessful(false)
            ->addMessage((new ResponseMessageTransfer())->setText(static::MESSAGE_COMPANY_USER_NOT_FOUND));

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function executeCompanyUserHydrationPlugins(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserTransfer {
        foreach ($this->companyUserHydrationPlugins as $companyUserHydrationPlugin) {
            $companyUserTransfer = $companyUserHydrationPlugin->hydrate($companyUserTransfer);
        }

        return $companyUserTransfer;
    }
}
