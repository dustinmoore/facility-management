<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduledEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Scheduled Events';
$this->params['breadcrumbs'][] = $this->title;
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
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">All Events</div>
            <!-- Table -->
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['attribute' => 'client',
                        'label' => 'Client(s)',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $clients = \app\models\ScheduleEventClient::findAll(['scheduled_event_id' => $data->id]);


                            $display = '';

                            foreach($clients as $client) {
                                $identity = \app\models\User::findIdentity($client->client_id);
                                $display .= $identity->userFullName . '<br />';
                            }

                            return $display;
                        }
                    ],
                    'event_title',
                    'start_date',
                    'end_date',
                    'start_time',
                    // 'end_time',
                    // 'is_active',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
