<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence;

use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsRepositoryInterface
{
    /**
     * @param int $idCustomer
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findWebUiSettingsByIdCustomer(int $idCustomer): ?WebUiSettingsTransfer;
}
