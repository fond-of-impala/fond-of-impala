<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk\ProductListsBulkProcessorInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\ProductListsBulkRestApiFactory;
use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class ProductListsBulkResourceControllerTest extends Unit
{
    protected ProductListsBulkRestApiFactory|MockObject $factoryMock;

    protected ProductListsBulkProcessorInterface|MockObject $ProductListsBulkProcessorMock;

    protected RestRequestInterface|MockObject $restRequestMock;

    protected RestProductListsBulkRequestAttributesTransfer|MockObject $restProductListsBulkRequestAttributesTransferMock;

    protected RestResponseInterface|MockObject $restResponseMock;

    protected ProductListsBulkResourceController $controller;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(ProductListsBulkRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListsBulkProcessorMock = $this->getMockBuilder(ProductListsBulkProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAttributesTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new class ($this->factoryMock) extends ProductListsBulkResourceController {
            protected AbstractFactory $abstractFactory;

            /**
             * @param \Spryker\Glue\Kernel\AbstractFactory $abstractFactory
             */
            public function __construct(AbstractFactory $abstractFactory)
            {
                $this->abstractFactory = $abstractFactory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->abstractFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testPostAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductListsBulkProcessor')
            ->willReturn($this->productListsBulkProcessorMock);

        $this->productListsBulkProcessorMock->expects(static::atLeastOnce())
            ->method('process')
            ->with(
                $this->restRequestMock,
                $this->restProductListsBulkRequestAttributesTransferMock,
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->postAction(
                $this->restRequestMock,
                $this->restProductListsBulkRequestAttributesTransferMock,
            ),
        );
    }
}
