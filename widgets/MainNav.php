<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

/**
 * MainNav widget encapsulates the main navigation bar functionality.
 */
class MainNav extends Widget
{
    /**
     * @var string the brand label text
     */
    public $brandLabel;

    /**
     * @var string|array the brand URL
     */
    public $brandUrl;

    /**
     * @var array the navbar options
     */
    public $navbarOptions = ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'];

    /**
     * @var array the nav options
     */
    public $navOptions = ['class' => 'navbar-nav'];

    /**
     * @var array the navigation items
     */
    public $items = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        if ($this->brandLabel === null) {
            $this->brandLabel = Yii::$app->name;
        }
        
        if ($this->brandUrl === null) {
            $this->brandUrl = Yii::$app->homeUrl;
        }
        
        if (empty($this->items)) {
            $this->items = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                Yii::$app->user->isGuest
                    ? ['label' => 'Login', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                        . Html::beginForm(['/site/logout'])
                        . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'nav-link btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>'
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        NavBar::begin([
            'brandLabel' => $this->brandLabel,
            'brandUrl' => $this->brandUrl,
            'options' => $this->navbarOptions,
        ]);
        
        echo Nav::widget([
            'options' => $this->navOptions,
            'items' => $this->items,
        ]);
        
        NavBar::end();
    }
}
