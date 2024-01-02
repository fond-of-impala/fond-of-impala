<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClient;
use FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreator;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleter;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReader;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdater;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\Container;

class CompanyUsersRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToCompanyUserReferenceClientInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReferenceClientMock;

    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiClient&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceClientMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserReferenceClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CompanyUsersRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->restResourceBuilderMock) extends CompanyUsersRestApiFactory {
            protected RestResourceBuilderInterface $restResourceBuilder;

            /**
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(RestResourceBuilderInterface $restResourceBuilder)
            {
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };
        $this->factory->setContainer($this->containerMock);
        $this->factory->setClient($this->clientMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserCreator(): void
    {
        static::assertInstanceOf(
            CompanyUserCreator::class,
            $this->factory->createCompanyUserCreator(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserUpdater(): void
    {
        static::assertInstanceOf(
            CompanyUserUpdater::class,
            $this->factory->createCompanyUserUpdater(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserDeleter(): void
    {
        static::assertInstanceOf(
            CompanyUserDeleter::class,
            $this->factory->createCompanyUserDeleter(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserReader(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUsersRestApiDependencyProvider::CLIENT_COMPANY_USER_REFERENCE)
            ->willReturn($this->companyUserReferenceClientMock);

        static::assertInstanceOf(
            CompanyUserReader::class,
            $this->factory->createCompanyUserReader(),
        );
    }
}
