<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimer;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaser;
use FondOfImpala\Zed\CollaborativeCartsRestApi\CollaborativeCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class CollaborativeCartsRestApiBusinessFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|CollaborativeCartsRestApiToQuoteFacadeInterface $quoteFacadeMock;

    protected MockObject|CollaborativeCartsRestApiToCollaborativeCartFacadeInterface $collaborativeCartFacadeMock;

    protected CollaborativeCartsRestApiBusinessFactory $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CollaborativeCartsRestApiToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartFacadeMock = $this->getMockBuilder(CollaborativeCartsRestApiToCollaborativeCartFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new CollaborativeCartsRestApiBusinessFactory();
        $this->businessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCartClaimer(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CollaborativeCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CollaborativeCartsRestApiDependencyProvider::FACADE_COLLABORATIVE_CART],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->collaborativeCartFacadeMock,
            );

        static::assertInstanceOf(
            CartClaimer::class,
            $this->businessFactory->createCartClaimer(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartReleaser(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CollaborativeCartsRestApiDependencyProvider::FACADE_QUOTE],
                [CollaborativeCartsRestApiDependencyProvider::FACADE_COLLABORATIVE_CART],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->collaborativeCartFacadeMock,
            );

        static::assertInstanceOf(
            CartReleaser::class,
            $this->businessFactory->createCartReleaser(),
        );
    }
}
