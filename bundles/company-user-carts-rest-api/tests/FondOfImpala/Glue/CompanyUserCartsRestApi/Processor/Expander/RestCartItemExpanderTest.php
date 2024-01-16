<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface;
use Generated\Shared\Transfer\RestCartItemTransfer;

class RestCartItemExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartItemExpanderPluginMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartItemTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Expander\RestCartItemExpander
     */
    protected $restCartItemExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCartItemExpanderPluginMock = $this->getMockBuilder(RestCartItemExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemExpander = new RestCartItemExpander(
            [
                $this->restCartItemExpanderPluginMock,
            ],
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->restCartItemExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restCartItemTransferMock)
            ->willReturn($this->restCartItemTransferMock);

        static::assertEquals(
            $this->restCartItemTransferMock,
            $this->restCartItemExpander->expand($this->restCartItemTransferMock),
        );
    }
}
