<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedule_event_client".
 *
 * @property integer $client_id
 * @property integer $scheduled_event_id
 *
 * @property ScheduledEvent $scheduledEvent
 * @property User $client
 */
class ScheduleEventClient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule_event_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'scheduled_event_id'], 'required'],
            [['client_id', 'scheduled_event_id'], 'integer'],
            [['scheduled_event_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduledEvent::className(), 'targetAttribute' => ['scheduled_event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Client ID',
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
