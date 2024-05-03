<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\WebUiSettingsTransfer;
use Orm\Zed\WebUiSettings\Persistence\FoiWebUiSettings;

interface WebUiSettingsMapperInterface
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
    ): WebUiSettingsTransfer;
}
