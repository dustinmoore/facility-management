<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scheduled_event".
 *
 * @property integer $id
 * @property string $event_title
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property integer $is_active
 *
 * @property ScheduleEventClient[] $scheduleEventClients
 * @property ScheduledEventFacilityRental[] $scheduledEventFacilityRentals
 * @property ScheduledEventTrainer[] $scheduledEventTrainers
 */
class ScheduledEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scheduled_event';
    }

    public $trainer;
    public $facility;
    public $client;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_title', 'start_time', 'end_time'], 'required'],
            [['start_date', 'end_date', 'start_time', 'end_time', 'trainer', 'facility', 'client'], 'safe'],
            [['is_active'], 'integer'],
            [['event_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_title' => 'Event Title',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleEventClients()
    {
        return $this->hasMany(ScheduleEventClient::className(), ['scheduled_event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledEventFacilityRentals()
    {
        return $this->hasMany(ScheduledEventFacilityRental::className(), ['scheduled_event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledEventTrainers()
    {
        return $this->hasMany(ScheduledEventTrainer::className(), ['scheduled_event_id' => 'id']);
    }
}
