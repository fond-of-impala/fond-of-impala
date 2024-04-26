<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\WebUiSettingsTransfer;
use JsonException;
use Orm\Zed\Customer\Persistence\FoiWebUiSettings;

class WebUiSettingsMapper implements WebUiSettingsMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     * @param \Orm\Zed\Customer\Persistence\FoiWebUiSettings|null $entity
     *
     * @return \Orm\Zed\Customer\Persistence\FoiWebUiSettings
     */
    public function fromTransferToEntity(WebUiSettingsTransfer $webUiSettingsTransfer, ?FoiWebUiSettings $entity = null): FoiWebUiSettings
    {
        if ($entity === null) {
            $entity = new FoiWebUiSettings();
        }

        $id = $entity->getIdWebUiSettings();
        $jsonData = '[]';

        try {
            $jsonData = json_encode($webUiSettingsTransfer->getCustomSettingData());
        } catch (JsonException $exception) {
            //ToDo: Logging
        }

        return $entity
            ->fromArray($webUiSettingsTransfer->modifiedToArray())
            ->setIdWebUiSettings($id)
            ->setCustomSettings($jsonData);
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\FoiWebUiSettings $entity
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer|null $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function fromEntityToTransfer(FoiWebUiSettings $entity, ?WebUiSettingsTransfer $webUiSettingsTransfer = null): WebUiSettingsTransfer
    {
        if ($webUiSettingsTransfer === null) {
            $webUiSettingsTransfer = new WebUiSettingsTransfer();
        }

        $data = [];
        try {
            $data = json_decode($entity->getCustomSettings());
        } catch (JsonException $exception) {
            //ToDo: Logging
        }

        return $webUiSettingsTransfer
            ->fromArray($entity->toArray(), true)
            ->setCustomSettingData($data);
    }
}
