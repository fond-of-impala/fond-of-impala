<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\WebUiSettingsTransfer;
use JsonException;
use Orm\Zed\WebUiSettings\Persistence\FoiWebUiSettings;

class WebUiSettingsMapper implements WebUiSettingsMapperInterface
{
    /**
     * @param \Orm\Zed\WebUiSettings\Persistence\FoiWebUiSettings $entity
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer|null $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function fromEntityToTransfer(
        FoiWebUiSettings $entity,
        ?WebUiSettingsTransfer $webUiSettingsTransfer = null
    ): WebUiSettingsTransfer {
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
