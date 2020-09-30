<?php
$this->title = 'Результат';
?>
<table  class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Вопрос</th>
      <th scope="col">Ответ</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach($model as $res):
?>
<tr>  
<td><?=$res->answers->questions->name;?></td>
<td><?= $res->answers->name?></td>
</tr>
<?php
endforeach;
?>
</tbody>
</table>