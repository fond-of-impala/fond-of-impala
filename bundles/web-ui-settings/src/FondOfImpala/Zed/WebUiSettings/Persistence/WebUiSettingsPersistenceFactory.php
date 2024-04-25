<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence;

use FondOfImpala\Zed\WebUiSettings\Persistence\Propel\Mapper\WebUiSettingsMapper;
use FondOfImpala\Zed\WebUiSettings\Persistence\Propel\Mapper\WebUiSettingsMapperInterface;
use Orm\Zed\Customer\Persistence\FoiWebUiSettingsQuery;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class WebUiSettingsPersistenceFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\WebUiSettings\Persistence\Propel\Mapper\WebUiSettingsMapperInterface
     */
    public function createWebUiSettingsMapper(): WebUiSettingsMapperInterface
    {
        return new WebUiSettingsMapper();
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\FoiWebUiSettingsQuery
     */
    public function createWebUiSettingsQuery(): FoiWebUiSettingsQuery
    {
        return FoiWebUiSettingsQuery::create()->clear();
    }
}
