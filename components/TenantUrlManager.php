<?php

namespace app\components;

use Yii;
use yii\web\UrlManager;

class TenantUrlManager extends UrlManager
{
    /**
     * @var string The tenant identifier parameter name in the URL
     */
    public $name = 'tenant_id';

    /**
     * @var array List of routes that should be excluded from tenant handling
     */
    public $blackList = [
        'site/login',
        'site/select-tenant',
        'site/logout',
        'login',
        'register',
        'site/index',
    ];

    /**
     * @var array List of domains that should be excluded from tenant detection
     */
    public $excludedDomains = [];

    /**
     * @var bool Whether the tenant is identified by subdomain
     */
    public $tenantBySubdomain = false;

    /**
     * @var bool Whether the tenant is identified by path
     */
    public $tenantByPath = true;
    public function createUrl($params)
    {
        $route = is_array($params) && isset($params[0]) ? $params[0] : null;
        if (in_array($route, $this->blackList)) {
            return parent::createUrl($params);
        }
        if (is_array($params) && !isset($params[$this->name])) {
            $tenantId = Yii::$app->request->get($this->name);
            if ($tenantId) {
                $params[$this->name] = $tenantId;
            }
        }
        return parent::createUrl($params);
    }
}
