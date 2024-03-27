<?php

namespace FondOfImpala\Glue\CustomerAppRestApi;

use FondOfImpala\Glue\CustomerAppRestApi\Dependency\Client\CustomerAppRestApiToCustomerClientInterface;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerAppMapper;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerAppMapperInterface;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerUpdater;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerUpdaterInterface;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\Validation\RestApiError;
use FondOfImpala\Glue\CustomerAppRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CustomerAppRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerUpdaterInterface
     */
    public function createCustomerUpdater(): CustomerUpdaterInterface
    {
        return new CustomerUpdater(
            $this->getCustomerClient(),
            $this->createCustomerAppMapper(),
            $this->createRestApiError(),
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp\CustomerAppMapperInterface
     */
    protected function createCustomerAppMapper(): CustomerAppMapperInterface
    {
        return new CustomerAppMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CustomerAppRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfImpala\Glue\CustomerAppRestApi\Dependency\Client\CustomerAppRestApiToCustomerClientInterface
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getCustomerClient(): CustomerAppRestApiToCustomerClientInterface
    {
        return $this->getProvidedDependency(CustomerAppRestApiDependencyProvider::CLIENT_CUSTOMER);
    }
}
