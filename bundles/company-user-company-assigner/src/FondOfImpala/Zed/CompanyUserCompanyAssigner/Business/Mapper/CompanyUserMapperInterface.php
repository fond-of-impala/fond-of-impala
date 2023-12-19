<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserMapperInterface
{
    /**
     * @param array<int, array<string, int>> $nonManufacturerData
     *
     * @return array<\Generated\Shared\Transfer\CompanyUserTransfer>
     */
    public function fromNonManufacturerData(array $nonManufacturerData): array;

    /**
     * @param array<string, int> $nonManufacturerDataItem
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function fromNonManufacturerDataItem(array $nonManufacturerDataItem): CompanyUserTransfer;
}
