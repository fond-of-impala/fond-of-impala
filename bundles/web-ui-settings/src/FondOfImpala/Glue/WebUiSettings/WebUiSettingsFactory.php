<?php

namespace FondOfImpala\Glue\WebUiSettings;

use FondOfImpala\Glue\WebUiSettings\Dependency\Client\WebUiSettingsToCustomerClientInterface;
use FondOfImpala\Glue\WebUiSettings\Processor\Validation\RestApiError;
use FondOfImpala\Glue\WebUiSettings\Processor\Validation\RestApiErrorInterface;
use FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\CustomerUpdater;
use FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\CustomerUpdaterInterface;
use FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\WebUiSettingsMapper;
use FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\WebUiSettingsMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class WebUiSettingsFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\CustomerUpdaterInterface
     */
    public function createCustomerUpdater(): CustomerUpdaterInterface
    {
        return new CustomerUpdater(
            $this->getCustomerClient(),
            $this->createWebUiSettingsMapper(),
            $this->createRestApiError(),
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings\WebUiSettingsMapperInterface
     */
    protected function createWebUiSettingsMapper(): WebUiSettingsMapperInterface
    {
        return new WebUiSettingsMapper();
    }

    /**
     * @return \FondOfImpala\Glue\WebUiSettings\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfImpala\Glue\WebUiSettings\Dependency\Client\WebUiSettingsToCustomerClientInterface
     */
    protected function getCustomerClient(): WebUiSettingsToCustomerClientInterface
    {
        return $this->getProvidedDependency(WebUiSettingsDependencyProvider::CLIENT_CUSTOMER);
    }
}
