<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Exception;
use FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig;
use FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Psr\Log\LoggerInterface;
use Throwable;

class CompanyTypeBlacklistValidator implements CompanyTypeBlacklistValidatorInterface
{
    protected CompanyTypeConverterConfig $config;

    protected CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade;

    protected LoggerInterface $logger;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyTypeConverter\CompanyTypeConverterConfig $config
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        CompanyTypeConverterToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyTypeConverterConfig $config,
        LoggerInterface $logger
    ) {
        $this->companyTypeFacade = $companyTypeFacade;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferFrom
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransferTo
     *
     * @return bool
     */
    public function validate(CompanyTransfer $companyTransferFrom, CompanyTransfer $companyTransferTo): bool
    {
        $companyTransferFrom->requireFkCompanyType();
        $companyTransferTo->requireFkCompanyType();

        try {
            return $this->canConvert($this->resolveCompanyType($companyTransferFrom), $this->resolveCompanyType($companyTransferTo));
        } catch (Throwable $exception) {
            $this->logger->warning($exception->getMessage(), $exception->getTrace());

            return false;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected function resolveCompanyType(CompanyTransfer $companyTransfer): CompanyTypeTransfer
    {
        $id = $companyTransfer->getFkCompanyType();
        $companyTypeTransfer = $companyTransfer->getCompanyType();

        if ($companyTypeTransfer === null || $companyTypeTransfer->getIdCompanyType() !== $id) {
            $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($id);

            return $this->fetchCompanyType($companyTypeTransfer);
        }

        return $companyTypeTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected function fetchCompanyType(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer
    {
        $companyTypeTransfer->requireIdCompanyType();

        $response = $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);

        if ($response->getIsSuccessful()) {
            return $response->getCompanyTypeTransfer();
        }

        throw new Exception(sprintf('Could not fetch company type with id "%s"', $companyTypeTransfer->getIdCompanyType()));
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeFrom
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTo
     *
     * @return bool
     */
    protected function canConvert(CompanyTypeTransfer $companyTypeFrom, CompanyTypeTransfer $companyTypeTo): bool
    {
        $nonConvertibleRoleTypeMapping = $this->config->getNonConvertibleRoleTypeKeys();

        if (array_key_exists($companyTypeFrom->getKey(), $nonConvertibleRoleTypeMapping) && in_array($companyTypeTo->getKey(), $nonConvertibleRoleTypeMapping[$companyTypeFrom->getKey()], true)) {
            return false;
        }

        if (array_key_exists($companyTypeFrom->getName(), $nonConvertibleRoleTypeMapping) && in_array($companyTypeTo->getName(), $nonConvertibleRoleTypeMapping[$companyTypeFrom->getName()], true)) {
            return false;
        }

        return true;
    }
}
