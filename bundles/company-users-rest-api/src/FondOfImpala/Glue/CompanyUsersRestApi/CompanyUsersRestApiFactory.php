<?php


declare(strict_types = 1);

namespace FondOfImpala\Glue\CompanyUsersRestApi;

use FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilder;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreator;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreatorInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleter;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilter;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilter;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapper;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapper;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapper;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReader;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReaderInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdater;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdaterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiError;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClientInterface getClient()
 */
class CompanyUsersRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReaderInterface
     */
    public function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getResourceBuilder(),
            $this->getClient(),
            $this->getCompanyUserReferenceClient(),
            $this->createCompanyUsersMapper(),
            $this->createRestApiError(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreatorInterface
     */
    public function createCompanyUserCreator(): CompanyUserCreatorInterface
    {
        return new CompanyUserCreator(
            $this->getResourceBuilder(),
            $this->getClient(),
            $this->createRestApiError(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdaterInterface
     */
    public function createCompanyUserUpdater(): CompanyUserUpdaterInterface
    {
        return new CompanyUserUpdater(
            $this->createRestWriteCompanyUserRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->createRestDeleteCompanyUserRequestMapper(),
            $this->createRestResponseBuilder(),
            $this->getClient(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestDeleteCompanyUserRequestMapperInterface
     */
    protected function createRestDeleteCompanyUserRequestMapper(): RestDeleteCompanyUserRequestMapperInterface
    {
        return new RestDeleteCompanyUserRequestMapper(
            $this->createIdCustomerFilter(),
            $this->createCompanyUserReferenceFilter(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\IdCustomerFilterInterface
     */
    protected function createIdCustomerFilter(): IdCustomerFilterInterface
    {
        return new IdCustomerFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Filter\CompanyUserReferenceFilterInterface
     */
    protected function createCompanyUserReferenceFilter(): CompanyUserReferenceFilterInterface
    {
        return new CompanyUserReferenceFilter();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Builder\RestResponseBuilderInterface
     */
    protected function createRestResponseBuilder(): RestResponseBuilderInterface
    {
        return new RestResponseBuilder(
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\CompanyUsersMapperInterface
     */
    protected function createCompanyUsersMapper(): CompanyUsersMapperInterface
    {
        return new CompanyUsersMapper(
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Mapper\RestWriteCompanyUserRequestMapperInterface
     */
    protected function createRestWriteCompanyUserRequestMapper(): RestWriteCompanyUserRequestMapperInterface
    {
        return new RestWriteCompanyUserRequestMapper(
            $this->createIdCustomerFilter(),
            $this->createCompanyUserReferenceFilter(),
        );
    }

    /**
     * @return \FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface
     */
    protected function getCompanyUserReferenceClient(): CompanyUsersRestApiToCompanyUserReferenceClientInterface
    {
        return $this->getProvidedDependency(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER_REFERENCE);
    }
}
