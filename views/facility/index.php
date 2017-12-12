<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FacilityRentalLookupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facility Rental Lookups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facility-rental-lookup-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Facility', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'rental_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
