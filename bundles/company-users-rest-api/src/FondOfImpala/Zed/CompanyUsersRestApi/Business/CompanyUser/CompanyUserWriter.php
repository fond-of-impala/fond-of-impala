<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser;

use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

class CompanyUserWriter implements CompanyUserWriterInterface
{
    protected CompanyUsersRestApiToCompanyFacadeInterface $companyFacade;

    protected CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade;

    protected CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade;

    protected CompanyUserMapperInterface $companyUserMapper;

    protected CompanyUserPluginExecutorInterface $companyUserPluginExecutor;

    protected RestApiErrorInterface $apiError;

    protected CompanyUserReaderInterface $companyUserReader;

    protected CompanyUsersRestApiConfig $companyUsersRestApiConfig;

    protected CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade;

    protected CustomerReaderInterface $customerReader;

    protected CustomerWriterInterface $customerWriter;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface $customerReader
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface $customerWriter
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface $companyFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface $companyUserMapper
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface $apiError
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $companyUsersRestApiConfig
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutorInterface $companyUserPluginExecutor
     */
    public function __construct(
        CustomerReaderInterface $customerReader,
        CustomerWriterInterface $customerWriter,
        CompanyUsersRestApiToCompanyFacadeInterface $companyFacade,
        CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyUsersRestApiToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserMapperInterface $companyUserMapper,
        RestApiErrorInterface $apiError,
        CompanyUserReaderInterface $companyUserReader,
        CompanyUsersRestApiConfig $companyUsersRestApiConfig,
        CompanyUsersRestApiToPermissionFacadeInterface $permissionFacade,
        CompanyUserPluginExecutorInterface $companyUserPluginExecutor
    ) {
        $this->customerReader = $customerReader;
        $this->customerWriter = $customerWriter;
        $this->companyFacade = $companyFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserFacade = $companyUserFacade;
        $this->companyUserMapper = $companyUserMapper;
        $this->apiError = $apiError;
        $this->companyUserReader = $companyUserReader;
        $this->companyUsersRestApiConfig = $companyUsersRestApiConfig;
        $this->permissionFacade = $permissionFacade;
        $this->companyUserPluginExecutor = $companyUserPluginExecutor;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        $companyResponseTransfer = $this->findCompanyByUuid(
            $restCompanyUsersRequestAttributesTransfer->getCompany()->getIdCompany(),
        );

        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer === null || !$companyResponseTransfer->getIsSuccessful()) {
            return $this->apiError->createCompanyNotFoundErrorResponse();
        }

        if (!$this->canCreate($restCompanyUsersRequestAttributesTransfer, $companyTransfer)) {
            return $this->apiError->createAccessDeniedErrorResponse();
        }

        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade
            ->findDefaultBusinessUnitByCompanyId($companyTransfer->getIdCompany());

        if ($companyBusinessUnitTransfer === null) {
            return $this->apiError->createDefaultCompanyBusinessUnitNotFoundErrorResponse();
        }

        $customerTransfer = $this->customerReader->getByRestCompanyUsersRequestAttributes(
            $restCompanyUsersRequestAttributesTransfer,
        );

        if ($customerTransfer === null) {
            $customerTransfer = $this->customerWriter->createByRestCompanyUsersRequestAttributes(
                $restCompanyUsersRequestAttributesTransfer,
            );
        }

        if ($customerTransfer === null) {
            return $this->apiError->createCouldNotCreateCustomerErrorResponse();
        }

        $companyUserTransfer = $this->prepareCompanyUserTransfer(
            $restCompanyUsersRequestAttributesTransfer,
            $companyTransfer,
            $companyBusinessUnitTransfer,
            $customerTransfer,
        );

        if ($this->companyUserReader->doesCompanyUserAlreadyExist($companyUserTransfer)) {
            return $this->apiError->createCompanyUserAlreadyExistErrorResponse();
        }

        $companyUserTransfer = $this->companyUserPluginExecutor->executePreCreatePlugins(
            $companyUserTransfer,
            $restCompanyUsersRequestAttributesTransfer,
        );

        $companyUserResponseTransfer = $this->companyUserFacade->create($companyUserTransfer);

        if (!$companyUserResponseTransfer->getIsSuccessful()) {
            return $this->apiError->createCompanyUsersDataInvalidErrorResponse();
        }

        $companyUserTransfer = $this->companyUserPluginExecutor->executePostCreatePlugins(
            $companyUserResponseTransfer->getCompanyUser(),
            $restCompanyUsersRequestAttributesTransfer,
        );

        return $this->createCompanyUsersResponseTransfer($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function prepareCompanyUserTransfer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyTransfer $companyTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        CustomerTransfer $customerTransfer
    ): CompanyUserTransfer {
        $companyUserTransfer = $this->mapRestCompanyUsersRequestAttributesTransferToCompanyUserTransfer(
            $restCompanyUsersRequestAttributesTransfer,
        );

        return $companyUserTransfer->setCompany($companyTransfer)
            ->setFkCompany($companyTransfer->getIdCompany())
            ->setCustomer($customerTransfer)
            ->setFkCustomer($customerTransfer->getIdCustomer())
            ->setCompanyBusinessUnit($companyBusinessUnitTransfer)
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit());
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function mapRestCompanyUsersRequestAttributesTransferToCompanyUserTransfer(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): CompanyUserTransfer {
        return $this->companyUserMapper->mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer(
            $restCompanyUsersRequestAttributesTransfer,
            new CompanyUserTransfer(),
        );
    }

    /**
     * @param string $companyUuid
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected function findCompanyByUuid(string $companyUuid): CompanyResponseTransfer
    {
        return $this->companyFacade
            ->findCompanyByUuid((new CompanyTransfer())->setUuid($companyUuid));
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function canCreate(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer,
        CompanyTransfer $companyTransfer
    ): bool {
        $idCompany = $companyTransfer->getIdCompany();

        $restCustomerTransfer = $restCompanyUsersRequestAttributesTransfer->getCurrentCustomer();

        if ($idCompany === null || $restCustomerTransfer === null || $restCustomerTransfer->getIdCustomer() === null) {
            return false;
        }

        $companyUserTransfer = $this->companyUserReader->getByIdCustomerAndIdCompany(
            $restCustomerTransfer->getIdCustomer(),
            $idCompany,
        );

        if ($companyUserTransfer === null || $companyUserTransfer->getIdCompanyUser() === null) {
            return false;
        }

        return $this->permissionFacade->can(
            WriteCompanyUserPermissionPlugin::KEY,
            $companyUserTransfer->getIdCompanyUser(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected function createCompanyUsersResponseTransfer(
        CompanyUserTransfer $companyUserTransfer
    ): RestCompanyUsersResponseTransfer {
        $restCompanyUsersResponseAttributesTransfer = new RestCompanyUsersResponseAttributesTransfer();
        $restCompanyUsersResponseAttributesTransfer->fromArray($companyUserTransfer->toArray(), true);

        $restCompanyUsersResponseTransfer = new RestCompanyUsersResponseTransfer();

        $restCompanyUsersResponseTransfer->setIsSuccess(true)
            ->setRestCompanyUsersResponseAttributes($restCompanyUsersResponseAttributesTransfer)
            ->setCompanyUser($companyUserTransfer);

        return $restCompanyUsersResponseTransfer;
    }
}
