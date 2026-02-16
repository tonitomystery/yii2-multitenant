<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\Tenant;
use app\models\TenantUser;
use app\models\User;

/**
 * BaseController provides common functionality for tenant-aware controllers.
 */
class BaseController extends Controller
{
    /**
     * @var Tenant|null Current tenant instance
     */
    public $tenant;

    /**
     * @var string|null Current tenant ID from URL parameter
     */
    public $tenant_id;

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Get tenant_id from GET parameter
        $this->tenant_id = Yii::$app->request->get('tenant_id');

        // If tenant_id is provided, verify and load tenant
        if ($this->tenant_id) {
            $this->tenant = Tenant::findOne($this->tenant_id);

            // Verify tenant exists
            if (!$this->tenant) {
                throw new ForbiddenHttpException('Tenant not found.');
            }

            // Verify user belongs to this tenant
            if (!Yii::$app->user->isGuest) {
                $userId = Yii::$app->user->id;
                $belongsToTenant = TenantUser::find()
                    ->where(['tenant_id' => $this->tenant_id, 'user_id' => $userId])
                    ->exists();

                if (!$belongsToTenant) {
                    throw new ForbiddenHttpException('You do not have access to this tenant.');
                }
            }


            // Set tenant ID in session
            Yii::$app->params['tenant_id'] = $this->tenant_id;
            Yii::$app->params['tenant'] = $this->tenant;
        }

        return true;
    }

    public function getUser(): User
    {
        return Yii::$app->user->identity;
    }
}
