<?php

namespace app\controllers;

use app\models\ScheduledEventFacilityRental;
use app\models\ScheduledEventTrainer;
use app\models\ScheduleEventClient;
use app\models\User;
use Yii;
use app\models\ScheduledEvent;
use app\models\ScheduledEventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

/**
 * ScheduledEventController implements the CRUD actions for ScheduledEvent model.
 */
class ScheduledEventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ScheduledEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScheduledEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ScheduledEvent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $trainers = ScheduledEventTrainer::findAll(['scheduled_event_id' => $id]);
        $rentals = ScheduledEventFacilityRental::findAll(['scheduled_event_id' => $id]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'trainers' => $trainers,
            'rentals' => $rentals
        ]);
    }

    /**
     * Creates a new ScheduledEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ScheduledEvent();
        $model->trainer = new ScheduledEventTrainer;
        $model->facility = new ScheduledEventFacilityRental;
        $model->client = new ScheduleEventClient;

        $model->setAttributes(Yii::$app->request->post());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach($_POST['ScheduleEventClient']['client_id'] as $client) {
                $newClient = new ScheduleEventClient();
                $newClient->client_id = $client;
                $newClient->scheduled_event_id = $model->id;
            }
            if($newClient->save()) {
                foreach($_POST['ScheduledEventTrainer']['trainer_id'] as $trainer) {
                    $newTrainer = new ScheduledEventTrainer();
                    $newTrainer->trainer_id = $trainer;
                    $newTrainer->scheduled_event_id = $model->id;
                }
                if($newTrainer->save()) {
                    foreach($_POST['ScheduledEventFacilityRental']['facility_id'] as $rental) {
                        $facilityRental = new ScheduledEventFacilityRental();
                        $facilityRental->facility_id = $rental;
                        $facilityRental->scheduled_event_id = $model->id;
                        $facilityRental->save();
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ScheduledEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ScheduledEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ScheduledEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ScheduledEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ScheduledEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTrainerSchedule($id)
    {
        $events = ScheduledEventTrainer::findAll(['trainer_id' => $id]);

        $schedule = array();
        foreach($events as $event) {
            $scheduledEvent = ScheduledEvent::findOne(['id' => $event->scheduled_event_id]);
            $schedule[] = $scheduledEvent;
        }

        $scheduleProvider = new ArrayDataProvider([
            'allModels' => $schedule,
            'sort' => [
                'attributes' => [
                    'id',
                    'event_title',
                    'start_date',
                    'end_date',
                    'start_time',
                    'end_time',
                    'is_active',
                ],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('trainerschedule', [
           'schedule' => $scheduleProvider
        ]);
    }

    public function actionClientSchedule($id)
    {
        $events = ScheduleEventClient::findAll(['client_id' => $id]);

        $schedule = array();
        foreach($events as $event) {
            $scheduledEvent = ScheduledEvent::findOne(['id' => $event->scheduled_event_id]);
            $schedule[] = $scheduledEvent;
        }

        $scheduleProvider = new ArrayDataProvider([
            'allModels' => $schedule,
            'sort' => [
                'attributes' => [
                    'id',
                    'event_title',
                    'start_date',
                    'end_date',
                    'start_time',
                    'end_time',
                    'is_active',
                ],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('clientschedule', [
            'schedule' => $scheduleProvider
        ]);
    }
}
