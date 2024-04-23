<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence;

use Generated\Shared\Transfer\WebUiSettingsTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorPersistenceFactory getFactory()
 */
class WebUiSettingsCustomerConnectorRepository extends AbstractRepository implements WebUiSettingsCustomerConnectorRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer|null
     */
    public function findWebUiSettingsByIdCustomer(int $idCustomer): ?WebUiSettingsTransfer
    {
        $query = $this->getFactory()->createWebUiSettingsQuery();

        $webUiSettings = $query
            ->useSpyCustomerQuery()
                ->filterByIdCustomer($idCustomer)
            ->endUse()
            ->findOne();

        if ($webUiSettings === null) {
            return null;
        }

        return $this->getFactory()->createWebUiSettingsMapper()->fromEntityToTransfer($webUiSettings);
    }
}
