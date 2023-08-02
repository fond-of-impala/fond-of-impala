<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation;

use Codeception\Test\Unit;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

class RestApiErrorTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Processor\Validation\RestApiError
     */
    protected $restApiError;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiError = new RestApiError();
    }

    /**
     * @return void
     */
    public function testAddAccessDeniedError(): void
    {
        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restApiError->addAccessDeniedError(
                $this->restResponseMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddCompanyUserNotFoundError(): void
    {
        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restApiError->addCompanyUserNotFoundError(
                $this->restResponseMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddCompanyRoleNotFoundError(): void
    {
        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restApiError->addCompanyRoleNotFoundError(
                $this->restResponseMock,
            ),
        );
    }
}
