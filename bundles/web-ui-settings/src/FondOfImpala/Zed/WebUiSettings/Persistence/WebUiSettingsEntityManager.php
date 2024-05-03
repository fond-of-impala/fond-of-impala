<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence;

use FondOfImpala\Zed\WebUiSettings\Persistence\Propel\Mapper\WebUiSettingsMapperInterface;
use Generated\Shared\Transfer\WebUiSettingsTransfer;
use Orm\Zed\WebUiSettings\Persistence\FoiWebUiSettingsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsPersistenceFactory getFactory()
 */
class WebUiSettingsEntityManager extends AbstractEntityManager implements WebUiSettingsEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function updateWebUiSettingsById(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer
    {
        $webUiSettingsTransfer->requireIdWebUiSettings();

        $entity = $this->getQuery()->filterByIdWebUiSettings($webUiSettingsTransfer->getIdWebUiSettings())->findOne();

        $entity = $this->getMapper()->fromTransferToEntity($webUiSettingsTransfer, $entity);

        $entity->save();

        return $this->getMapper()->fromEntityToTransfer($entity);
    }

    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function createWebUiSettings(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer
    {
        $entity = $this->getMapper()->fromTransferToEntity($webUiSettingsTransfer);

        $entity->save();

        return $this->getMapper()->fromEntityToTransfer($entity);
    }

    /**
     * @return \Orm\Zed\WebUiSettings\Persistence\FoiWebUiSettingsQuery
     */
    protected function getQuery(): FoiWebUiSettingsQuery
    {
        return $this->getFactory()->createWebUiSettingsQuery();
    }

    /**
     * @return \FondOfImpala\Zed\WebUiSettings\Persistence\Propel\Mapper\WebUiSettingsMapperInterface
     */
    protected function getMapper(): WebUiSettingsMapperInterface
    {
        return $this->getFactory()->createWebUiSettingsMapper();
    }
}
