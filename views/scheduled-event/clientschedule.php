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
<div class="site-index">

    <h4>Elite Training Academy - Trainer Schedule</h4>

    <div class="col-lg-12">
        <p>
            <?= Html::a('Create Scheduled Event', ['scheduled-event/create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Schedule</div>
            <!-- Table -->
            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $schedule,
                'columns' => [
                    'event_title',
                    ['attribute' => 'start_date',
                        'label' => 'Date',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return date('l, m-d-Y', strtotime($data->start_date));
                        }
                    ],
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
</div>