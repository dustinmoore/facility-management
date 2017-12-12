<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\CurrentOrderStatus;
use app\models\User;
use app\models\ScheduledEventFacilityRental;
use yii\data\ArrayDataProvider;
?>
<style>
    .summary {
        display: none;

    }
</style>
<div class="scheduled-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-lg-12">
        <p>
            <?= Html::a('Create Scheduled Event', ['scheduled-event/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="panel panel-success">
            <!-- Default panel contents -->
            <div class="panel-heading">ETA Clients</div>
            <!-- Table -->
            <?= GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    'userFullName',
                    'username',
                    'userEmail',
                    ['attribute' => 'schedule',
                        'label' => 'Trainer Schedule',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('View Schedule', ['scheduled-event/client-schedule', 'id' => $data['id']]);
                        }
                    ],
                ]

            ]); ?>
        </div>
    </div>

</div>

