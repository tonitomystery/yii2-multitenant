<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $items */
/** @var string|null $selectedId */
?>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="tenantDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-building me-1"></i>
        <?= isset($items[$selectedId]) ? Html::encode($items[$selectedId]) : 'Select Tenant' ?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="tenantDropdown">
        <li>
            <h6 class="dropdown-header">Switch Workspace</h6>
        </li>
        <?php foreach ($items as $id => $name): ?>
            <li>
                <?php
                // Construct URL based on current route but with new tenant_id
                // We assume the route is controller/action and tenant_id param is handled by UrlManager
                // If we are in a tenant context, we want to stay on the same page but switch tenant?
                // Or maybe just go to dashboard of that tenant. Let's go to dashboard for simplicity first,
                // or try to preserve route if possible.
                // Simplified: Go to site/index of that tenant for now to avoid route errors.
                // Update: User might want to stay on same page. Let's try to use current route.
                $route = Yii::$app->controller->route;
                $params = Yii::$app->request->get();
                $params[0] = $route;
                $params['tenant_id'] = $id;
                // Avoid piling up params if not needed, but safe to pass existing GET params.
                ?>
                <a class="dropdown-item <?= $selectedId === $id ? 'active' : '' ?>"
                    href="<?= Url::to($params) ?>">
                    <?= Html::encode($name) ?>
                </a>
            </li>
        <?php endforeach; ?>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item" href="<?= Url::to(['/tenant/create']) ?>">
                <i class="bi bi-plus-circle me-1"></i> Create New Tenant
            </a>
        </li>
    </ul>
</li>