<?php

namespace adminlte\widgets\covers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget([
 *     'options' => [
 *         'class' => 'alert-info',
 *     ],
 *     'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the alert box:
 *
 * ```php
 * Alert::begin([
 *     'options' => [
 *         'class' => 'alert-warning',
 *     ],
 * ]);
 *
 * echo 'Say hello...';
 *
 * Alert::end();
 * ```
 *
 * @see http://getbootstrap.com/components/#alerts
 */
class Alert extends \yii\bootstrap\Alert
{
    /**
     * @var array Alert icons
     */
    public $alertIcons = [
        'error' => 'fa-ban',
        'danger' => 'fa-ban',
        'success' => 'fa-check',
        'info' => 'fa-info',
        'warning' => 'a-warning'
    ];

    /**
     * @var string Alert type
     */
    public $type = 'success';

    /**
     * Renders the close button if any before rendering the content.
     * @return string the rendering result
     */
    protected function renderBodyBegin()
    {
        echo Html::tag('i', '', ['class' => 'fa ' . $this->alertIcons[$this->type]]);
        return $this->renderCloseButton();
    }
}
