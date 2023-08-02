<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;

class RestApiErrorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiError
     */
    protected $restApiError;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restApiError = new RestApiError();
    }

    /**
     * @return void
     */
    public function testCreateCompanyNotFoundErrorResponse(): void
    {
        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->restApiError->createCompanyNotFoundErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserAlreadyExistErrorResponse(): void
    {
        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->restApiError->createCompanyUserAlreadyExistErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateDefaultCompanyBusinessUnitNotFoundErrorResponse(): void
    {
        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->restApiError->createDefaultCompanyBusinessUnitNotFoundErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUsersDataInvalidErrorResponse(): void
    {
        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->restApiError->createCompanyUsersDataInvalidErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCouldNotCreateCustomerErrorResponse(): void
    {
        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->restApiError->createCouldNotCreateCustomerErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateDefaultCompanyRoleNotFoundErrorResponse(): void
    {
        $this->assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->restApiError->createDefaultCompanyRoleNotFoundErrorResponse(),
        );
    }
}
