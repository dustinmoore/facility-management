<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\CurrentOrderStatus;
use app\models\User;
use app\models\ScheduledEventFacilityRental;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */

$this->title = 'ETA Dashboard';

$users = \app\models\User::findAllUsers();
$clients = array();
foreach($users as $user) {
    if($user['userType'] == 'client') {
        $clients[] = $user;
    }
}

$users = \app\models\User::findAllUsers();
$trainers = array();
foreach($users as $user) {
    if($user['userType'] == 'trainer') {
        $trainers[] = $user;
    }
}

$provider = new ArrayDataProvider([
    'allModels' => $trainers,
    'sort' => [
        'attributes' => [
            'id',
            'username',
            'password',
            'authKey',
            'accessToken',
            'userType',
            'userEmail',
            'userFullName'
        ],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
]);

?>
<style>
    .summary {
        display: none;
        
    }
</style>
<div class="site-index">

    <h4>Elite Training Academy - Facility Dashboard</h4>

    <div class="col-lg-12">
        <p>
            <?= Html::a('Create Scheduled Event', ['scheduled-event/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Today's Schedule</div>
            <!-- Table -->
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['attribute' => 'client',
                        'label' => 'Client(s)',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $clients = \app\models\ScheduleEventClient::findAll(['scheduled_event_id' => $data->id]);


                            $display = '';

                            foreach($clients as $client) {
                                $identity = User::findIdentity($client->client_id);
                                $display .= $identity->userFullName . '<br />';
                            }

                            return $display;
                        }
                    ],
                    'event_title',
                    ['attribute' => 'start_time',
                        'label' => 'Start Time',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('h:i a', strtotime($data->start_time));
                        }
                    ],
                    ['attribute' => 'end_time',
                        'label' => 'End Time',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('h:i a', strtotime($data->end_time));
                        }
                    ],
                    ['attribute' => 'facility_rental',
                        'label' => 'Facility Usage',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $facilties = ScheduledEventFacilityRental::findAll(['scheduled_event_id' => $data->id]);

                            $display = '<ul>';

                            foreach($facilties as $facilty) {
                                $display .= '<li>' . $facilty->facility->rental_name . '</li>';
                            }

                            $display .= '</ul>';

                            return $display;
                        }
                    ],
                    ['attribute' => 'trainer',
                        'label' => 'Trainer(s)',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $trainers = \app\models\ScheduledEventTrainer::findAll(['scheduled_event_id' => $data->id]);


                            $display = '<ul>';

                            foreach($trainers as $trainer) {
                                $identity = User::findIdentity($trainer->trainer_id);
                                $display .= '<li>' . $identity->userFullName . '</li>';
                            }

                            $display .= '</ul>';

                            return $display;
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading">Tomorrow's Schedule</div>
            <!-- Table -->
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $tomorrowProvider,
                'columns' => [
                    'event_title',
                    ['attribute' => 'start_time',
                        'label' => 'Start Time',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('h:i a', strtotime($data->start_time));
                        }
                    ],
                    ['attribute' => 'facility_rental',
                        'label' => 'Facility Usage',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $facilties = ScheduledEventFacilityRental::findAll(['scheduled_event_id' => $data->id]);

                            $display = '<ul>';

                            foreach($facilties as $facilty) {
                                $display .= '<li>' . $facilty->facility->rental_name . '</li>';
                            }

                            $display .= '</ul>';

                            return $display;
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-warning">
            <!-- Default panel contents -->
            <div class="panel-heading">Trainers</div>
            <!-- Table -->
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $provider,
                'columns' => [
                    'userFullName',
                    'userEmail',
                    ['attribute' => 'schedule',
                        'label' => 'Trainer Schedule',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('View Schedule', ['scheduled-event/trainer-schedule', 'id' => $data['id']]);
                        }
                    ],
                ]

            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
