<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ScheduledEvent */

$this->title = 'Create Scheduled Event';
$this->params['breadcrumbs'][] = ['label' => 'Scheduled Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduled-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
