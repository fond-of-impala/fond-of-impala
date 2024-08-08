<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Communication\Plugin\OmsExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\OrderConfirmationRecipientsOverrideFacade;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RemoveNonInternalRecipientsOrderMailExpanderPluginTest extends Unit
{
    protected MailTransfer|MockObject $mailTransferMock;

    protected OrderTransfer|MockObject $orderTransferMock;

    protected OrderConfirmationRecipientsOverrideFacade|MockObject $facadeMock;

    protected RemoveNonInternalRecipientsOrderMailExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(OrderConfirmationRecipientsOverrideFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new RemoveNonInternalRecipientsOrderMailExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpandTrue(): void
    {
        $this->facadeMock
            ->expects(static::atLeastOnce())
            ->method('expandOrderMailTransfer')
            ->willReturn($this->mailTransferMock);

        $this->plugin->expand($this->mailTransferMock, $this->orderTransferMock);
    }
}
