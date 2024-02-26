<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCompanySearchRestApi\Communication\Plugin\CompanySearchRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityCompanySearchRestApi\ConditionalAvailabilityCompanySearchRestApiConfig;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\RestCompanySearchResultItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AvailabilityChannelFallbackRestCompanySearchResultItemExpanderPluginTest extends Unit
{
    protected ConditionalAvailabilityCompanySearchRestApiConfig|MockObject $configMock;

    protected RestCompanySearchResultItemTransfer|MockObject $restCompanySearchResultItemTransferMock;

    protected CompanyTransfer|MockObject $companyTransferMock;

    protected AvailabilityChannelFallbackRestCompanySearchResultItemExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityCompanySearchRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanySearchResultItemTransferMock = $this->getMockBuilder(RestCompanySearchResultItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new AvailabilityChannelFallbackRestCompanySearchResultItemExpanderPlugin();
        $this->plugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getAvailabilityChannel')
            ->willReturn('B2B');

        $this->restCompanySearchResultItemTransferMock->expects(static::atLeastOnce())
            ->method('setAvailabilityChannel')
            ->willReturnSelf();

        static::assertEquals(
            $this->restCompanySearchResultItemTransferMock,
            $this->plugin->expand($this->restCompanySearchResultItemTransferMock, $this->companyTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandFallback(): void
    {
        $this->configMock->expects(static::atLeastOnce())
            ->method('getFallbackAvailabilityChannel')
            ->willReturn('B2B');

        $this->restCompanySearchResultItemTransferMock->expects(static::atLeastOnce())
            ->method('setAvailabilityChannel')
            ->willReturnSelf();

        static::assertEquals(
            $this->restCompanySearchResultItemTransferMock,
            $this->plugin->expand($this->restCompanySearchResultItemTransferMock, $this->companyTransferMock),
        );
    }
}
