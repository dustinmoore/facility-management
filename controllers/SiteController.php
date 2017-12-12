<?php

namespace app\controllers;

use app\models\ScheduledEvent;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use edofre\fullcalendar\models\Event;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view-calendar', 'view-clients'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ScheduledEvent::find()->where(['start_date' => date('Y-m-d')]),
        ]);
        $tomorrowProvider = new ActiveDataProvider([
            'query' => ScheduledEvent::find()->where(['start_date' => date('Y-m-d', strtotime('+1 day'))]),
        ]);

        return $this->render('index', array(
            'dataProvider' => $dataProvider,
            'tomorrowProvider' => $tomorrowProvider
        ));
    }

    public function actionViewCalendar()
    {
        $calendarEvents = ScheduledEvent::find()->all();

        $events = array();

        foreach($calendarEvents as $event) {
            $combinedStart = date('Y-m-d H:i:s', strtotime("$event->start_date $event->start_time"));
            $combinedEnd = date('Y-m-d H:i:s', strtotime("$event->end_date $event->end_time"));
            $events[] = new Event([
                'id'               => $event->id,
                'title'            => $event->event_title,
                'start'            => date("c", strtotime(date($combinedStart))),
                'end'              => date("c", strtotime(date($combinedEnd))),
                'color'            => 'green',
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]);
        }

        return $this->render('calendar', array(
            'events' => $events
        ));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionViewClients()
    {
        $users = \app\models\User::findAllUsers();
        $clients = array();
        foreach($users as $user) {
            if($user['userType'] == 'client') {
                $clients[] = $user;
            }
        }

        $provider = new ArrayDataProvider([
            'allModels' => $clients,
            'sort' => [
                'attributes' => [
                    'id',
                    'username',
                    'password',
                    'authKey',
                    'accessToken',
                    'userType',
                    'userEmail',
                    'userFullName'
                ],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('clients', array(
            'provider' => $provider
        ));


    }

    public function actionViewScheduleByClient($id)
    {

    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * @param $id
     * @param $start
     * @param $end
     * @return array
     */
    public function actionEvents($id, $start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            // minimum
            new Event([
                'title' => 'Appointment #' . rand(1, 999),
                'start' => '2016-03-18T14:00:00',
            ]),
            // Everything editable
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-17T12:30:00',
                'end'              => '2016-03-17T13:30:00',
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]),
            // No overlap
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-17T15:30:00',
                'end'              => '2016-03-17T19:30:00',
                'overlap'          => false, // Overlap is default true
                'editable'         => true,
                'startEditable'    => true,
                'durationEditable' => true,
            ]),
            // Only duration editable
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-16T11:00:00',
                'end'              => '2016-03-16T11:30:00',
                'startEditable'    => false,
                'durationEditable' => true,
            ]),
            // Only start editable
            new Event([
                'id'               => uniqid(),
                'title'            => 'Appointment #' . rand(1, 999),
                'start'            => '2016-03-15T14:00:00',
                'end'              => '2016-03-15T15:30:00',
                'startEditable'    => true,
                'durationEditable' => false,
            ]),
        ];
    }
}
