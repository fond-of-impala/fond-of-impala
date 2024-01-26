<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ReleaseCartRequestMapperTest extends Unit
{
    protected MockObject|RestReleaseCartRequestTransfer $restReleaseCartRequestTransferMock;

    protected ReleaseCartRequestMapper $claimCartRequestMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->claimCartRequestMapper = new ReleaseCartRequestMapper();
    }

    /**
     * @return void
     */
    public function testFromRestReleaseCartRequest(): void
    {
        $this->restReleaseCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        static::assertInstanceOf(
            ReleaseCartRequestTransfer::class,
            $this->claimCartRequestMapper->fromRestReleaseCartRequest($this->restReleaseCartRequestTransferMock),
        );
    }
}
