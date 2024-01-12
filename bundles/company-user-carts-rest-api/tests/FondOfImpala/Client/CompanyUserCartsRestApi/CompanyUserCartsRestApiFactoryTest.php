<?php

namespace FondOfImpala\Client\CompanyUserCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyUserCartsRestApi\Zed\CompanyUserCartsRestApiStub;
use Spryker\Client\Kernel\Container;

class CompanyUserCartsRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container|mixed
     */
    protected $containerMock;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\Dependency\Client\CompanyUserCartsRestApiToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyUserCartsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CompanyUserCartsRestApiFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserCartsRestApiStub(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(CompanyUserCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            CompanyUserCartsRestApiStub::class,
            $this->factory
                ->createCompanyUserCartsRestApiStub(),
        );
    }
}
