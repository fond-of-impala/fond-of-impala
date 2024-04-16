<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence;

use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer|null
     */
    public function findWebUiSettingsByIdCustomer(int $idCustomer): ?WebUiSettingsTransfer;
}
