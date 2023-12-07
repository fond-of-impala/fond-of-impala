<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;

class ConditionalAvailabilityPageSearchToUtilEncodingServiceBridgeTest extends Unit
{
    protected MockObject|UtilEncodingServiceInterface $utilEncodingServiceMock;

    protected ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->utilEncodingServiceMock = $this->getMockBuilder(UtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityPageSearchToUtilEncodingServiceBridge(
            $this->utilEncodingServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testEncodeJson(): void
    {
        $encodedJsonString = 'encoded-json-string';

        $this->utilEncodingServiceMock->expects(static::atLeastOnce())
            ->method('encodeJson')
            ->with([])
            ->willReturn($encodedJsonString);

        static::assertEquals($encodedJsonString, $this->bridge->encodeJson([]));
    }

    /**
     * @return void
     */
    public function testDecodeJson(): void
    {
        $encodedJsonString = 'encoded-json-string';

        $this->utilEncodingServiceMock->expects(static::atLeastOnce())
            ->method('decodeJson')
            ->with($encodedJsonString)
            ->willReturn([]);

        static::assertEquals([], $this->bridge->decodeJson($encodedJsonString));
    }
}
