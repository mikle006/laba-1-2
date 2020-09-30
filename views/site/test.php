<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UrlManager;
use kartik\select2\Select2;

/* @var $this yii\web\View */

$this->title = 'Тесты';
?>
<ul>
<?php foreach ($model as $test):
    echo '<li class="nav-link">
      <a href="/site/vopr?question=1&test='.$test['id'].'" class="nav-link active ">
      '.$test->name . '  :  '. $test->description.'
      </a>
      </li>';
    endforeach;
    ?>
</ul>
<a class = 'btn btn-primary' href="tests/create">Добавить новый тест</a>
<a class = 'btn btn-primary' href="questions/create">Добавить новый вопрос</a>
<a class = 'btn btn-primary' href="answers/create">Добавить новый ответ</a>
