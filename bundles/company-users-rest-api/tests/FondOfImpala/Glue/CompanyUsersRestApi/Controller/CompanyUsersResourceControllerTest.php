<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreatorInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleterInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReaderInterface;
use FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdaterInterface;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompanyUsersResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyUsersRestApi\Processor\Deleter\CompanyUserDeleterInterface
     */
    protected $companyUserDeleterMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Updater\CompanyUserUpdaterInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserUpdaterMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Creator\CompanyUserCreatorInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserCreatorMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUsersReaderMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiFactory&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restResponseMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Controller\CompanyUsersResourceController|\FondOfImpala\Glue\CompanyUsersRestApi\Controller\__anonymous @4229
     */
    protected $controller;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserDeleterMock = $this->getMockBuilder(CompanyUserDeleterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserUpdaterMock = $this->getMockBuilder(CompanyUserUpdaterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCreatorMock = $this->getMockBuilder(CompanyUserCreatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CompanyUsersRestApiFactory::class)
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

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new class ($this->factoryMock) extends CompanyUsersResourceController
        {
            protected AbstractFactory $mockedFactory;

            /**
             * @param \Spryker\Glue\Kernel\AbstractFactory $mockedFactory
             */
            public function __construct(AbstractFactory $mockedFactory)
            {
                $this->mockedFactory = $mockedFactory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            public function getFactory(): AbstractFactory
            {
                return $this->mockedFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testPostAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserCreator')
            ->willReturn($this->companyUserCreatorMock);

        $this->companyUserCreatorMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->restRequestMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->postAction(
                $this->restRequestMock,
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetActionWithId(): void
    {
        $uuid = '6486c64d-cb3f-410f-8df3-352fc2d2ec49';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserReader')
            ->willReturn($this->companyUsersReaderMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        $this->companyUsersReaderMock->expects(static::atLeastOnce())
            ->method('findCompanyUser')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $this->companyUsersReaderMock->expects(static::never())
            ->method('findCurrentCompanyUsers')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->getAction($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserReader')
            ->willReturn($this->companyUsersReaderMock);

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->companyUsersReaderMock->expects(static::never())
            ->method('findCompanyUser')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $this->companyUsersReaderMock->expects(static::atLeastOnce())
            ->method('findCurrentCompanyUsers')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->getAction($this->restRequestMock),
        );
    }

    /**
     * @return void
     */
    public function testPatchAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserUpdater')
            ->willReturn($this->companyUserUpdaterMock);

        $this->companyUserUpdaterMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->restRequestMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->patchAction(
                $this->restRequestMock,
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testDeleteAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserDeleter')
            ->willReturn($this->companyUserDeleterMock);

        $this->companyUserDeleterMock->expects(static::atLeastOnce())
            ->method('delete')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->deleteAction($this->restRequestMock),
        );
    }
}
