<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilderTest extends Unit
{
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    protected MockObject|RestResponseInterface $restResponseMock;

    protected RestResponseBuilder $restResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilder = new RestResponseBuilder($this->restResourceBuilderMock);
    }

    /**
     * @return void
     */
    public function testBuildEmptyRestResponse(): void
    {

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('setStatus')
            ->with(Response::HTTP_NO_CONTENT)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildEmptyRestResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateRestErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturn($this->restResponseMock);

        $restResponse = $this->restResponseBuilder->createRestErrorResponse('error', 0);

        static::assertEquals($this->restResponseMock, $restResponse);
        static::assertIsArray($restResponse->getErrors());
    }
}
