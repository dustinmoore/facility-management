<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scheduled_event_facility_rental".
 *
 * @property integer $scheduled_event_id
 * @property integer $facility_id
 *
 * @property ScheduledEvent $scheduledEvent
 * @property FacilityRentalLookup $facility
 */
class ScheduledEventFacilityRental extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scheduled_event_facility_rental';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scheduled_event_id', 'facility_id'], 'required'],
            [['scheduled_event_id', 'facility_id'], 'integer'],
            [['scheduled_event_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduledEvent::className(), 'targetAttribute' => ['scheduled_event_id' => 'id']],
            [['facility_id'], 'exist', 'skipOnError' => true, 'targetClass' => FacilityRentalLookup::className(), 'targetAttribute' => ['facility_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'scheduled_event_id' => 'Scheduled Event ID',
            'facility_id' => 'Facility ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledEvent()
    {
        return $this->hasOne(ScheduledEvent::className(), ['id' => 'scheduled_event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacility()
    {
        return $this->hasOne(FacilityRentalLookup::className(), ['id' => 'facility_id']);
    }
}
