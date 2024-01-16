<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestReleaseCartRequestExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCustomerFilterMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCustomerTransferMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpander
     */
    protected $restReleaseCartRequestExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCustomerFilterMock = $this->getMockBuilder(RestCustomerFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestExpander = new RestReleaseCartRequestExpander(
            $this->restCustomerFilterMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $customerReference = 'FOO--1';

        $this->restCustomerFilterMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->restReleaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setCurrentCustomerReference')
            ->with($customerReference)
            ->willReturn($this->restReleaseCartRequestTransferMock);

        static::assertEquals(
            $this->restReleaseCartRequestTransferMock,
            $this->restReleaseCartRequestExpander->expand(
                $this->restReleaseCartRequestTransferMock,
                $this->restRequestMock,
            ),
        );
    }
}
