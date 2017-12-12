<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ScheduledEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scheduled-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    $users = \app\models\User::findAllUsers();
    $clients = array();
    foreach($users as $user) {
        if($user['userType'] == 'client') {
            $clients[] = $user;
        }
    }

    $clients = ArrayHelper::map($clients, 'id', 'userFullName');
    echo $form->field($model->client, 'client_id')->dropDownList($clients, [
        'multiple'=>'multiple',
    ]);

    ?>

    <?= $form->field($model, 'event_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time')->textInput()->widget(TimePicker::className(),
        [
            'readonly' => true,
            'pluginOptions' => [
                'minuteStep' => 30,
                'showMeridian' => false,
            ],
            'options'=>[
                'class'=>'form-control',
            ],
        ]); ?>

    <?= $form->field($model, 'end_time')->textInput()->widget(TimePicker::className(),
        [
            'readonly' => true,
            'pluginOptions' => [
                'minuteStep' => 30,
                'showMeridian' => false,
            ],
            'options'=>[
                'class'=>'form-control',
            ],
        ]); ?>

    <?= $form->field($model, 'start_date')->textInput()->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'end_date')->textInput()->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?php
    $items = ArrayHelper::map(\app\models\User::findAllUsers(), 'id', 'userFullName');
    echo $form->field($model->trainer, 'trainer_id')->dropDownList($items, [
        'multiple'=>'multiple',
    ]);

    ?>

    <?php
    $items = ArrayHelper::map(\app\models\FacilityRentalLookup::find()->all(), 'id', 'rental_name');
    echo $form->field($model->facility, 'facility_id')->dropDownList($items, [
        'multiple'=>'multiple',
    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
