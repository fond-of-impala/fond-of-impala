<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationApiValidatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidatorInterface
     */
    protected ErpOrderCancellationApiValidatorInterface $validator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validator = new ErpOrderCancellationApiValidator();
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        static::assertIsArray(
            $this->validator->validate($this->apiRequestTransferMock),
        );
    }
}
