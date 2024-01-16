<?php

namespace FondOfImpala\Client\CompanyUserQuote;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyUserQuote\Zed\CompanyUserQuoteStubInterface;
use Spryker\Client\Kernel\Container;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CompanyUserQuoteFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyUserQuote\CompanyUserQuoteFactory
     */
    protected $companyUserQuoteFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientInterfaceMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteFactory = new CompanyUserQuoteFactory();
        $this->companyUserQuoteFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedCompanyUserQuoteStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompanyUserQuoteDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientInterfaceMock);

        $this->assertInstanceOf(
            CompanyUserQuoteStubInterface::class,
            $this->companyUserQuoteFactory->createZedCompanyUserQuoteStub(),
        );
    }
}
