<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Tests;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Questions */
/* @var $form yii\widgets\ActiveForm */
$test = Tests::find()->all();
$items = ArrayHelper::map($test,'id','name');
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'id_test')->widget(Select2::classname(), [
    'data' => $items,
    'options' => ['placeholder' => 'Выберите тест'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
