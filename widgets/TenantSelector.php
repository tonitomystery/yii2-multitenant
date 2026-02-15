<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use app\models\Tenant;

/**
 * TenantSelector widget renders a dropdown with search filter for selecting tenants.
 */
class TenantSelector extends Widget
{
    /**
     * @var string|null the selected tenant ID
     */
    public $selectedId = null;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if ($this->selectedId === null && Yii::$app->request->get('tenant_id')) {
            $this->selectedId = Yii::$app->request->get('tenant_id');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // Get all tenants for the dropdown
        // In a real scenario, you might want to filter by user's authorized tenants
        $query = Tenant::find()
            ->select(['id', 'name'])
            ->orderBy(['name' => SORT_ASC]);

        $tenants = $query->all();
        $items = ArrayHelper::map($tenants, 'id', 'name');

        return $this->render('tenantSelector', [
            'items' => $items,
            'selectedId' => $this->selectedId,
        ]);
    }
}
