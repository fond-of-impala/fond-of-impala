<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client\CollaborativeCartsRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CollaborativeCartsRestApi\Zed\CollaborativeCartsRestApiStub;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;

class CollaborativeCartsRestApiFactoryTest extends Unit
{
    protected CollaborativeCartsRestApiFactory $collaborativeCartsRestApiFactory;

    protected MockObject|Container $containerMock;

    protected MockObject|CollaborativeCartsRestApiToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(CollaborativeCartsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsRestApiFactory = new CollaborativeCartsRestApiFactory();
        $this->collaborativeCartsRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCollaborativeCartsRestApiStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CollaborativeCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->zedRequestClientMock);

        $this->assertInstanceOf(
            CollaborativeCartsRestApiStub::class,
            $this->collaborativeCartsRestApiFactory->createCollaborativeCartsRestApiStub(),
        );
    }
}
