<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UrlManager;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */

$this->title = 'Начинаем';
$questionNum = $id_question - 1;
    echo '<h1>'.$Vopros1[$questionNum]['name'].'</h1><br/>';
$answerArr = [];
foreach($answers as $answer):
    $answerArr[$answer['id']] = $answer['name'];
endforeach;
$id_answer="1";
?>
<br><br><br>
<p id="qNum" style="display: none;"><?= $Vopros1[$questionNum]['id']?></p>
<?php
$form = ActiveForm::begin();
echo $form->field($model, 'id_answers')->input('hidden')->label('');
echo $form->field($model, 'id_answers')->widget(Select2::classname(), [
    'data' => $answerArr,
    'options' => [
        'placeholder' => 'Выберите ответ...',
        'id' => 'answerButton',
        'disabled' => $answerState
    ],
])->label('');
echo Html::submitButton('Далее', ['class' => 'btn btn-success']);
if ($id_question > 1) {
    echo Html::a('Назад', Url::current(['question' => $id_question-1]), ['class' => 'btn btn-primary']);
}


ActiveForm::end();
?>
<script>
$("#w0").find('#answerButton').on('change', function () {
    var id_answer = $(this).val();
    var qNum = $('#qNum').html();
    $('#useranswers-id_answers').val(id_answer);
    $(this).attr('disabled', 'true');
$.ajax({
        url:    "/site/answercorrect", //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        data: {"answerid": id_answer, "qNum": qNum},  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            if(response){
            alert('Верно');
            } else {
            alert('Неверно');
            };  
console.log(response);
        },
        error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
        }
});
});
</script>
