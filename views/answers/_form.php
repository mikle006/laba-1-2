<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Tests;
use app\models\Questions;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Answers */
/* @var $form yii\widgets\ActiveForm */
$test = Tests::find()->all();
$items = ArrayHelper::map($test,'id','name');
$que = Questions::find()->all();
$value = ArrayHelper::map($que,'id','name');
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isCorrect')->textInput() ?>

    <?= $form->field($model, 'id_test')->widget(Select2::classname(), [
    'data' => $items,
    'options' => ['placeholder' => 'Выберите тест'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

<?= $form->field($model, 'id_questions')->widget(Select2::classname(), [
    'data' => $value,
    'options' => ['placeholder' => 'Выберите '],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
