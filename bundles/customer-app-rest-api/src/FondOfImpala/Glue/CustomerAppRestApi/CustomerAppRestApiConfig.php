<?php

namespace FondOfImpala\Glue\CustomerAppRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CustomerAppRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_APP = 'customer-app';

    /**
     * @var string
     */
    public const CONTROLLER_CUSTOMER_APP = 'customer-app-resource';

    /**
     * @var string
     */
    public const ACTION_CUSTOMER_APP_PATCH = 'patch';

    /**
     * @var string
     */
    public const RESPONSE_CODE_REFERENCE_MISSING = '800';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_REFERENCE_MISSING = 'Reference is missing.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_NOT_MATCH = '801';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_CUSTOMER_NOT_MATCH = 'Customer does not match given customer reference.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_APP_DATA_NOT_UPDATED = '802';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_APP_DATA_NOT_UPDATED = 'Could not update customer app data.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_APP_DATA_INVALID = '803';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_APP_DATA_INVALID = 'The customer app data are invalid.';
}
