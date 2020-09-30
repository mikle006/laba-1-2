<?

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Questions;
use app\models\Answers;
use app\models\Tests;
use app\models\UserAnswers;
use yii\helpers\Url;
class TestController extends Controller{
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
    }