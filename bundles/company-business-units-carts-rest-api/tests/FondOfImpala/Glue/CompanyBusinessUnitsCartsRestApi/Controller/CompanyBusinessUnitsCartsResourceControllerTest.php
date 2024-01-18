<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiFactory;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReaderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompanyBusinessUnitsCartsResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiFactory
     */
    protected $companyBusinessUnitsCartsRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReaderInterface
     */
    protected $cartReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Controller\CompanyBusinessUnitsCartsResourceController
     */
    protected $companyBusinessUnitsCartsResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsCartsRestApiFactory = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReaderMock = $this->getMockBuilder(CartReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsResourceController = new class ($this->companyBusinessUnitsCartsRestApiFactory) extends CompanyBusinessUnitsCartsResourceController {
            /**
             * @var \Spryker\Glue\Kernel\AbstractFactory
             */
            protected $factory;

            /**
             *  constructor.
             *
             * @param \Spryker\Glue\Kernel\AbstractFactory $factory
             */
            public function __construct(AbstractFactory $factory)
            {
                $this->factory = $factory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            public function getFactory(): AbstractFactory
            {
                return $this->factory;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetActionForSingleResource(): void
    {
        $cartUuid = 'cf1b54f0-032b-11eb-adc1-0242ac120002';

        $this->restRequestMock->expects(self::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('getId')
            ->willReturn($cartUuid);

        $this->companyBusinessUnitsCartsRestApiFactory->expects(self::atLeastOnce())
            ->method('createCartReader')
            ->willReturn($this->cartReaderMock);

        $this->cartReaderMock->expects(self::atLeastOnce())
            ->method('getCart')
            ->with($cartUuid, $this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->companyBusinessUnitsCartsResourceController->getAction($this->restRequestMock);

        self::assertEquals($this->restResponseMock, $restResponse);
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->restRequestMock->expects(self::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->companyBusinessUnitsCartsRestApiFactory->expects(self::atLeastOnce())
            ->method('createCartReader')
            ->willReturn($this->cartReaderMock);

        $this->cartReaderMock->expects(self::atLeastOnce())
            ->method('findCarts')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->companyBusinessUnitsCartsResourceController->getAction($this->restRequestMock);

        self::assertEquals($this->restResponseMock, $restResponse);
    }
}
