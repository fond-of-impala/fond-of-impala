<?php

namespace FondOfImpala\Glue\ErpOrderCancellationRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class ErpOrderCancellationRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_ERP_ORDER_CANCELLATION_REST_API = 'erp-order-cancellation';

    /**
     * @var string
     */
    public const CONTROLLER_RESOURCE_ERP_ORDER_CANCELLATION_REST_API = 'erp-order-cancellation-resource';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_USER_IS_NOT_ALLOWED_TO_ADD_ERP_ORDER_CANCELLATION = 'Missing permission to add erp order cancellation!';

    /**
     * @var int
     */
    public const RESPONSE_CODE_USER_IS_NOT_ALLOWED_TO_ADD_ERP_ORDER_CANCELLATION = 0;
}
