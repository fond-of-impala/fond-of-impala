<?php

namespace FondOfImpala\Shared\ErpOrderCancellation;

interface ErpOrderCancellationConstants
{
    /**
     * @var string
     */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public const PREFIX_TO_REPLACE = 'FOI:ERP_ORDER_CANCELLATION:PREFIX_TO_REPLACE';

    public const DEFAULT_PREFIX_TO_REPLACE = 'PS';

    public const PREFIX = 'FOI:ERP_ORDER_CANCELLATION:PREFIX';

    public const DEFAULT_PREFIX = 'PS-OC';
}
