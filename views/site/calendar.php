<?php

use yii\web\JsExpression;


/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?= edofre\fullcalendar\Fullcalendar::widget([
        'events'        => $events
    ]);
    ?>
</div>
