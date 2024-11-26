<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\CartClaimer;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteExpander;
use FondOfImpala\Zed\CollaborativeCart\Business\Releaser\CartReleaser;
use FondOfImpala\Zed\CollaborativeCart\CollaborativeCartDependencyProvider;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToPermissionFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepository;
use Spryker\Zed\Kernel\Container;

class CollaborativeCartBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface
     */
    protected $customerFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface
     */
    protected $quoteFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartBusinessFactory
     */
    protected $collaborativeCartBusinessFactory;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CollaborativeCartToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeMock = $this->getMockBuilder(CollaborativeCartToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CollaborativeCartToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CollaborativeCartToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CollaborativeCartRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartBusinessFactory = new CollaborativeCartBusinessFactory();
        $this->collaborativeCartBusinessFactory->setContainer($this->containerMock);
        $this->collaborativeCartBusinessFactory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateCartClaimer(): void
    {
        $self = $this;

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CollaborativeCartDependencyProvider::FACADE_QUOTE:
                        return $self->quoteFacadeMock;
                    case CollaborativeCartDependencyProvider::FACADE_PERMISSION:
                        return $self->permissionFacadeMock;
                    default:
                        throw new Exception('Unexpected call');
                }
            });

        self::assertInstanceOf(
            CartClaimer::class,
            $this->collaborativeCartBusinessFactory->createCartClaimer(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartReleaser(): void
    {
        $self = $this;

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CollaborativeCartDependencyProvider::FACADE_QUOTE:
                        return $self->quoteFacadeMock;
                    case CollaborativeCartDependencyProvider::FACADE_PERMISSION:
                        return $self->permissionFacadeMock;
                    default:
                        throw new Exception('Unexpected call');
                }
            });

        self::assertInstanceOf(
            CartReleaser::class,
            $this->collaborativeCartBusinessFactory->createCartReleaser(),
        );
    }

    /**
     * @return void
     */
    public function testCreateQuoteExpander(): void
    {
        $self = $this;

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case CollaborativeCartDependencyProvider::FACADE_CUSTOMER:
                        return $self->customerFacadeMock;
                    case CollaborativeCartDependencyProvider::FACADE_COMPANY_USER_REFERENCE:
                        return $self->companyUserReferenceFacadeMock;
                    default:
                        throw new Exception('Unexpected call');
                }
            });

        self::assertInstanceOf(
            QuoteExpander::class,
            $this->collaborativeCartBusinessFactory->createQuoteExpander(),
        );
    }
}
