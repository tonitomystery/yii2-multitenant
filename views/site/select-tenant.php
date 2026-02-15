<?php

/** @var yii\web\View $this */
/** @var app\models\Tenant[] $tenants */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Select Tenant';
?>
<div class="site-select-tenant">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Choose Your Workspace</h1>
        <p class="lead">Select a tenant to continue or create a new one.</p>
    </div>

    <div class="body-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="list-group">
                    <?php foreach ($tenants as $tenant): ?>
                        <?= Html::beginForm(['site/select-tenant'], 'post', ['class' => 'list-group-item list-group-item-action p-0']) ?>
                        <?= Html::hiddenInput('tenant_id', $tenant->id) ?>
                        <button type="submit" class="btn btn-block btn-lg w-100 text-start py-3 px-4 d-flex justify-content-between align-items-center bg-white border-0">
                            <span class="fw-bold"><?= Html::encode($tenant->name) ?></span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                        <?= Html::endForm() ?>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 text-center">
                    <p>Don't see your workspace?</p>
                    <?= Html::a('Create New Tenant', ['tenant/create'], ['class' => 'btn btn-outline-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>