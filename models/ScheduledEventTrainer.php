<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scheduled_event_trainer".
 *
 * @property integer $trainer_id
 * @property integer $scheduled_event_id
 *
 * @property ScheduledEvent $scheduledEvent
 * @property User $trainer
 */
class ScheduledEventTrainer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scheduled_event_trainer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'scheduled_event_id'], 'required'],
            [['trainer_id', 'scheduled_event_id'], 'integer'],
            [['scheduled_event_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduledEvent::className(), 'targetAttribute' => ['scheduled_event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trainer_id' => 'Trainer ID',
            'scheduled_event_id' => 'Scheduled Event ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledEvent()
    {
        return $this->hasOne(ScheduledEvent::className(), ['id' => 'scheduled_event_id']);
    }
}
