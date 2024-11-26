<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Claimer\CartClaimer;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\Releaser\CartReleaser;
use FondOfImpala\Zed\CollaborativeCartsRestApi\CollaborativeCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface;
use Spryker\Zed\Kernel\Container;

class CollaborativeCartsRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToQuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCartsRestApi\Dependency\Facade\CollaborativeCartsRestApiToCollaborativeCartFacadeInterface
     */
    protected $collaborativeCartFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiBusinessFactory
     */
    protected $businessFactory;

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
        $self = $this;

        $this->containerMock->expects($self->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                if ($key === CollaborativeCartsRestApiDependencyProvider::FACADE_QUOTE) {
                    return $self->quoteFacadeMock;
                }

                if ($key === CollaborativeCartsRestApiDependencyProvider::FACADE_COLLABORATIVE_CART) {
                    return $self->collaborativeCartFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

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
        $self = $this;

        $this->containerMock->expects($self->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                if ($key === CollaborativeCartsRestApiDependencyProvider::FACADE_QUOTE) {
                    return $self->quoteFacadeMock;
                }

                if ($key === CollaborativeCartsRestApiDependencyProvider::FACADE_COLLABORATIVE_CART) {
                    return $self->collaborativeCartFacadeMock;
                }

                throw new Exception('Unexpected call');
            });

        static::assertInstanceOf(
            CartReleaser::class,
            $this->businessFactory->createCartReleaser(),
        );
    }
}
