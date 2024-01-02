<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiFactory;
use FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessorInterface;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompanyUsersBulkRestApiResourceControllerTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\CompanyUsersBulk\CompanyUsersBulkProcessorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $processorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkRequestAttributesTransfer|MockObject $restCompanyUsersBulkRequestAttributesTransfer;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersBulkRestApi\Controller\CompanyUsersBulkResourceController
     */
    protected $controller;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyUsersBulkRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->processorMock = $this->getMockBuilder(CompanyUsersBulkProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkRequestAttributesTransfer = $this->getMockBuilder(RestCompanyUsersBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new class ($this->factoryMock) extends CompanyUsersBulkResourceController {
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
            ->method('createCompanyUsersBulkProcessor')
            ->willReturn($this->processorMock);

        $this->processorMock->expects(static::atLeastOnce())
            ->method('process')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->postAction(
                $this->restRequestMock,
                $this->restCompanyUsersBulkRequestAttributesTransfer,
            ),
        );
    }
}
