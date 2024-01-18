<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed\CompanyBusinessUnitsCartsRestApiZedStub;
use Spryker\Client\Kernel\Container;

class CompanyBusinessUnitsCartsRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiFactory
     */
    protected $companyBusinessUnitsCartsRestApiFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsRestApiFactory = new CompanyBusinessUnitsCartsRestApiFactory();
        $this->companyBusinessUnitsCartsRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitsCartsRestApiZedStub(): void
    {
        $this->containerMock->expects(self::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(self::atLeastOnce())
            ->method('get')
            ->with(CompanyBusinessUnitsCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        self::assertInstanceOf(
            CompanyBusinessUnitsCartsRestApiZedStub::class,
            $this->companyBusinessUnitsCartsRestApiFactory->createCompanyBusinessUnitsCartsRestApiZedStub(),
        );
    }
}
