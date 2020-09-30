<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Questions;
use app\models\Answers;
use app\models\ContactForm;
use app\models\Tests;
use app\models\UserAnswers;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
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
        return $this->render('index');
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

        $model->password = '';
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

    /**
     * Displays about page.
     *
     * @return string
     */
   /**
    * 
    */
    public function actionTest()
    {

        $query = Tests ::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>5]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('test', ['model' => $models,
        'pages' => $pages,
    ]);
    }
public function actionVopr()
    {   
     $id_test = Yii::$app->request->get('test');
     $id_question = Yii::$app->request->get('question');
     $Vopros1= Questions::find()->where(['id_test'=>$id_test])->asArray()->all();
     $answers = Answers::find()->where(['id_test'=>$id_test])->andWhere(['id_questions' => $Vopros1[$id_question-1]['id']])->asArray()->all();
     $model = new UserAnswers;
     $nextP = $id_question+1;
     $lastAnswered = UserAnswers::find()->joinWith('answers')->where(['id_user' => Yii::$app->user->id])->andWhere(['answers.id_test' => $id_test])->andWhere(['answers.id_questions' => $Vopros1[$id_question-1]['id']])->asArray()->one();
     $answerState = isset($lastAnswered['id']);
     if ($answerState){
         $model->id_answers = $lastAnswered['id_answers'];
     }
     if($model->load(Yii::$app->request->post())){
         if ($answerState){
            Yii::$app->response->redirect(Url::current(['question' => $nextP], ['class' => 'btn btn-primary']));
         } else {
            $model->id_user = Yii::$app->user->id;
            $model->save(false);
            Yii::$app->response->redirect(Url::current(['question' => $nextP], ['class' => 'btn btn-primary']));
         }
     }
     if ($id_question > 10) {
        return $this->redirect('/site/result/');
    }
    return $this->render('vopr',compact('Vopros1','answers','id_question','model', 'answerState', 'lastAnswered'));
    }
    public function actionAnswercorrect(){
        $correctanswer = Answers::find()->where(['isCorrect'=>'1'])->andWhere(['id_questions' => $_POST['qNum']])->asArray()->one();
        if($_POST['answerid']==$correctanswer['id']){
            return true;
        }else{
            return false;
        }
      
    }
    public function actionResult(){
        $model = UserAnswers::find()->all();
        return $this->render("result",['model'=>$model,]);
    }
    }
    
    

