<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\TenantUser;

/**
 * DashboardController displays the main dashboard for authenticated users.
 */
class DashboardController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays the dashboard homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // Get current tenant from BaseController
        $currentTenant = $this->tenant;

        // Get user's tenants
        $tenants = $user->tenants;

        // Get tenant statistics
        $stats = $this->getTenantStats($this->tenant_id);

        return $this->render('index', [
            'user' => $user,
            'currentTenant' => $currentTenant,
            'tenants' => $tenants,
            'stats' => $stats,
        ]);
    }

    /**
     * Get statistics for the current tenant.
     *
     * @param string|null $tenantId
     * @return array
     */
    protected function getTenantStats($tenantId)
    {
        if (!$tenantId) {
            return [
                'total_users' => 0,
                'total_tenants' => 0,
            ];
        }

        // Count users in current tenant
        $totalUsers = TenantUser::find()
            ->where(['tenant_id' => $tenantId])
            ->count();

        // Count total tenants for current user
        $totalTenants = $this->getUser()->getTenants()->count();

        return [
            'total_users' => $totalUsers,
            'total_tenants' => $totalTenants,
        ];
    }
}
