<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ClaimCartRequestMapperTest extends Unit
{
    protected MockObject|RestClaimCartRequestTransfer $restClaimCartRequestTransferMock;

    protected ClaimCartRequestMapper $claimCartRequestMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestMapper = new ClaimCartRequestMapper();
    }

    /**
     * @return void
     */
    public function testFromRestClaimCartRequest(): void
    {
        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        static::assertInstanceOf(
            ClaimCartRequestTransfer::class,
            $this->claimCartRequestMapper->fromRestClaimCartRequest($this->restClaimCartRequestTransferMock),
        );
    }
}
