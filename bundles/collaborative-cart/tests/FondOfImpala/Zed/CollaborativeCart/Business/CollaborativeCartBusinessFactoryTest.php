<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business;

use Codeception\Test\Unit;
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
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CollaborativeCartDependencyProvider::FACADE_QUOTE],
                [CollaborativeCartDependencyProvider::FACADE_QUOTE],
                [CollaborativeCartDependencyProvider::FACADE_PERMISSION],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->quoteFacadeMock,
                $this->permissionFacadeMock,
            );

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
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CollaborativeCartDependencyProvider::FACADE_QUOTE],
                [CollaborativeCartDependencyProvider::FACADE_QUOTE],
            )->willReturnOnConsecutiveCalls(
                $this->quoteFacadeMock,
                $this->quoteFacadeMock,
                $this->permissionFacadeMock,
            );

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
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CollaborativeCartDependencyProvider::FACADE_CUSTOMER],
                [CollaborativeCartDependencyProvider::FACADE_COMPANY_USER_REFERENCE],
            )->willReturnOnConsecutiveCalls(
                $this->customerFacadeMock,
                $this->companyUserReferenceFacadeMock,
            );

        self::assertInstanceOf(
            QuoteExpander::class,
            $this->collaborativeCartBusinessFactory->createQuoteExpander(),
        );
    }
}
