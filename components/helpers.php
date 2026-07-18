<?php

// use Yii; 

use app\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\ArrayHelper;

function url($url = '', $scheme = false)
{
    return Url::to($url, $scheme);
}

function he($text)
{
    return Html::encode($text);
}

function ph($text)
{
    return HtmlPurifier::process($text);
}

function t($message, $params = [], $category = 'app', $language = null)
{
    return Yii::t($category, $message, $params, $language);
}

function param($name, $default = null)
{
    return ArrayHelper::getValue(Yii::$app->params, $name, $default);
}
function loadConfig($name)
{
    $basePath = dirname(__DIR__);

    $cacheFile = $basePath . "/config/cache/{$name}.php";

    if (file_exists($cacheFile)) {
        return require $cacheFile;
    }

    return require $basePath . "/config/{$name}.php";
}

function user(): User
{
    /** @var User $user */
    return Yii::$app->user->identity;
}

function tenant()
{
    return Yii::$app->params['institution'];
}
function tenantid()
{
    return Yii::$app->params['institution']->uid;
}
