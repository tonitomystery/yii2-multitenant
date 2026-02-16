<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\Tenant;
use app\models\TenantUser;

/**
 * DashboardController displays the main dashboard for authenticated users.
 */
class DashboardController extends Controller
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
        $tenantId = Yii::$app->session->get('tenant_id');
        $tenantName = Yii::$app->session->get('tenant_name');

        // Get current tenant if set
        $currentTenant = null;
        if ($tenantId) {
            $currentTenant = Tenant::findOne($tenantId);
        }

        // Get user's tenants
        $tenants = $user->tenants;

        // Get tenant statistics
        $stats = $this->getTenantStats($tenantId);

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
        $totalTenants = Yii::$app->user->identity->getTenants()->count();

        return [
            'total_users' => $totalUsers,
            'total_tenants' => $totalTenants,
        ];
    }
}
