<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var app\models\Tenant $currentTenant */
/** @var app\models\Tenant[] $tenants */
/** @var array $stats */

$this->title = 'Dashboard';
?>
<div class="dashboard-index">
    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php if ($currentTenant): ?>
                <div class="alert alert-info">
                    <strong>Current Tenant:</strong> <?= Html::encode($currentTenant->name) ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <strong>No tenant selected.</strong>
                    <?= Html::a('Select a tenant', ['site/select-tenant'], ['class' => 'alert-link']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-user" style="font-size: 48px;"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size: 36px;"><?= $stats['total_users'] ?></div>
                            <div>Users in Tenant</div>
                        </div>
                    </div>
                </div>
                <?php if ($currentTenant): ?>
                    <a href="<?= Url::to(['tenant/view', 'id' => $currentTenant->id]) ?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="glyphicon glyphicon-home" style="font-size: 48px;"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size: 36px;"><?= $stats['total_tenants'] ?></div>
                            <div>My Tenants</div>
                        </div>
                    </div>
                </div>
                <a href="<?= Url::to(['tenant/index']) ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View All Tenants</span>
                        <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-list"></i> My Tenants
                    </h3>
                </div>
                <div class="panel-body">
                    <?php if (!empty($tenants)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tenants as $tenant): ?>
                                        <tr>
                                            <td>
                                                <?= Html::encode($tenant->name) ?>
                                                <?php if ($currentTenant && $currentTenant->id === $tenant->id): ?>
                                                    <span class="label label-success">Active</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= Yii::$app->formatter->asDatetime($tenant->created_at) ?></td>
                                            <td>
                                                <?= Html::a('View', ['tenant/view', 'id' => $tenant->id], ['class' => 'btn btn-sm btn-primary']) ?>
                                                <?php if (!$currentTenant || $currentTenant->id !== $tenant->id): ?>
                                                    <?= Html::a('Select', ['site/index', 'tenant_id' => $tenant->id], ['class' => 'btn btn-sm btn-success']) ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>You don't have any tenants yet.</p>
                        <p><?= Html::a('Create your first tenant', ['tenant/create'], ['class' => 'btn btn-success']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-info-sign"></i> Quick Links
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?= Html::a(
                            '<i class="glyphicon glyphicon-plus"></i> Create New Tenant',
                            ['tenant/create'],
                            ['class' => 'list-group-item']
                        ) ?>
                        <?= Html::a(
                            '<i class="glyphicon glyphicon-list"></i> View All Tenants',
                            ['tenant/index'],
                            ['class' => 'list-group-item']
                        ) ?>
                        <?= Html::a(
                            '<i class="glyphicon glyphicon-refresh"></i> Switch Tenant',
                            ['site/select-tenant'],
                            ['class' => 'list-group-item']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .panel-green {
        border-color: #5cb85c;
    }

    .panel-green>.panel-heading {
        border-color: #5cb85c;
        color: white;
        background-color: #5cb85c;
    }

    .panel-green>a {
        color: #5cb85c;
    }

    .panel-green>a:hover {
        color: #3d8b3d;
    }
</style>