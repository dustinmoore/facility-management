<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facility_rental_lookup".
 *
 * @property integer $id
 * @property string $rental_name
 *
 * @property ScheduledEventFacilityRental[] $scheduledEventFacilityRentals
 */
class FacilityRentalLookup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facility_rental_lookup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rental_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rental_name' => 'Rental Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduledEventFacilityRentals()
    {
        return $this->hasMany(ScheduledEventFacilityRental::className(), ['facility_id' => 'id']);
    }
}
