<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi;

use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Creator\CartCreator;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Creator\CartCreatorInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter\CartDeleter;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter\CartDeleterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpander;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpanderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CompanyUserReferenceFilter;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CustomerReferenceFilter;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCartFilter;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCartFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCustomerFilter;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCustomerFilterInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Finder\CartFinder;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Finder\CartFinderInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapper;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapper;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapper;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapper;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapper;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Updater\CartUpdater;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Updater\CartUpdaterInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig getConfig()
 * @method \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiClient getClient()
 */
class CompanyUserCartsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Creator\CartCreatorInterface
     */
    public function createCartCreator(): CartCreatorInterface
    {
        return new CartCreator(
            $this->createRestCompanyUserCartsRequestMapper(),
            $this->createRestCartItemExpander(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Updater\CartUpdater
     */
    public function createCartUpdater(): CartUpdaterInterface
    {
        return new CartUpdater(
            $this->createRestCompanyUserCartsRequestMapper(),
            $this->createRestCartItemExpander(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Deleter\CartDeleterInterface
     */
    public function createCartDeleter(): CartDeleterInterface
    {
        return new CartDeleter(
            $this->createRestCompanyUserCartsRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Finder\CartFinderInterface
     */
    public function createCartFinder(): CartFinderInterface
    {
        return new CartFinder(
            $this->createRestCompanyUserCartsRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCompanyUserCartsRequestMapperInterface
     */
    protected function createRestCompanyUserCartsRequestMapper(): RestCompanyUserCartsRequestMapperInterface
    {
        return new RestCompanyUserCartsRequestMapper(
            $this->createIdCartFilter(),
            $this->createCompanyUserReferenceFilter(),
            $this->createCustomerReferenceFilter(),
            $this->createIdCustomerFilter(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCartFilterInterface
     */
    protected function createIdCartFilter(): IdCartFilterInterface
    {
        return new IdCartFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CompanyUserReferenceFilterInterface
     */
    protected function createCompanyUserReferenceFilter(): CompanyUserReferenceFilterInterface
    {
        return new CompanyUserReferenceFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CustomerReferenceFilterInterface
     */
    protected function createCustomerReferenceFilter(): CustomerReferenceFilterInterface
    {
        return new CustomerReferenceFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\IdCustomerFilterInterface
     */
    protected function createIdCustomerFilter(): IdCustomerFilterInterface
    {
        return new IdCustomerFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpanderInterface
     */
    protected function createRestCartItemExpander(): RestCartItemExpanderInterface
    {
        return new RestCartItemExpander(
            $this->getRestCartItemExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder(
            $this->createRestCartsAttributesMapper(),
            $this->createRestItemsAttributesMapper(),
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface
     */
    protected function createRestCartsAttributesMapper(): RestCartsAttributesMapperInterface
    {
        return new RestCartsAttributesMapper(
            $this->createRestCartsDiscountsMapper(),
            $this->createRestCartsTotalsMapper(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsDiscountsMapperInterface
     */
    protected function createRestCartsDiscountsMapper(): RestCartsDiscountsMapperInterface
    {
        return new RestCartsDiscountsMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsTotalsMapperInterface
     */
    protected function createRestCartsTotalsMapper(): RestCartsTotalsMapperInterface
    {
        return new RestCartsTotalsMapper();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface
     */
    protected function createRestItemsAttributesMapper(): RestItemsAttributesMapperInterface
    {
        return new RestItemsAttributesMapper();
    }

    /**
     * @return array<\FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface>
     */
    protected function getRestCartItemExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::PLUGINS_REST_CART_ITEM_EXPANDER);
    }
}
