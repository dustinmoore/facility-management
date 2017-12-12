<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FacilityRentalLookup */

$this->title = 'Create Facility Rental Lookup';
$this->params['breadcrumbs'][] = ['label' => 'Facility Rental Lookups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facility-rental-lookup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
