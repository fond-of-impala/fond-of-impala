<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence;

use Generated\Shared\Transfer\WebUiSettingsTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsPersistenceFactory getFactory()
 */
class WebUiSettingsRepository extends AbstractRepository implements WebUiSettingsRepositoryInterface
{
    /**
     * @param int $idCustomer
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findWebUiSettingsByIdCustomer(int $idCustomer): ?WebUiSettingsTransfer
    {
        $query = $this->getFactory()->createWebUiSettingsQuery();

        $webUiSettings = $query
            ->useSpyCustomerQuery()
                ->filterByIdCustomer($idCustomer)
            ->endUse()
            ->findOne();

        if ($webUiSettings === null){
            return null;
        }

        return $this->getFactory()->createWebUiSettingsMapper()->fromEntityToTransfer($webUiSettings);
    }
}
