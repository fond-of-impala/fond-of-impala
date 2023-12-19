<?php

namespace FondOfImpala\Zed\CompanyType\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\FoiCompanyTypeEntityTransfer;
use Orm\Zed\CompanyType\Persistence\FoiCompanyType;

class CompanyTypeMapper implements CompanyTypeMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyType\Persistence\FoiCompanyType $foiCompanyType
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function mapEntityToTransfer(
        FoiCompanyType $foiCompanyType,
        CompanyTypeTransfer $companyTypeTransfer
    ): CompanyTypeTransfer {
        return $companyTypeTransfer->fromArray(
            $foiCompanyType->toArray(),
            true,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Orm\Zed\CompanyType\Persistence\FoiCompanyType $foiCompanyType
     *
     * @return \Orm\Zed\CompanyType\Persistence\FoiCompanyType
     */
    public function mapTransferToEntity(
        CompanyTypeTransfer $companyTypeTransfer,
        FoiCompanyType $foiCompanyType
    ): FoiCompanyType {
        $foiCompanyType->fromArray(
            $companyTypeTransfer->modifiedToArray(false),
        );

        return $foiCompanyType;
    }

    /**
     * @param \Generated\Shared\Transfer\FoiCompanyTypeEntityTransfer $foiCompanyTypeEntityTransfer
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function mapEntityTransferToTransfer(
        FoiCompanyTypeEntityTransfer $foiCompanyTypeEntityTransfer,
        CompanyTypeTransfer $companyTypeTransfer
    ): CompanyTypeTransfer {
        return $companyTypeTransfer->fromArray(
            $foiCompanyTypeEntityTransfer->toArray(),
            true,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\FoiCompanyTypeEntityTransfer $foiCompanyTypeEntityTransfer
     *
     * @return \Generated\Shared\Transfer\FoiCompanyTypeEntityTransfer
     */
    public function mapTransferToEntityTransfer(
        CompanyTypeTransfer $companyTypeTransfer,
        FoiCompanyTypeEntityTransfer $foiCompanyTypeEntityTransfer
    ): FoiCompanyTypeEntityTransfer {
        $foiCompanyTypeEntityTransfer->fromArray(
            $companyTypeTransfer->modifiedToArray(false),
        );

        return $foiCompanyTypeEntityTransfer;
    }
}
