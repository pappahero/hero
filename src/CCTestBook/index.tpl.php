  <h1>TestBook (MedEmobBook v.2)</h1>
  <p>Handle information about people</p>

<?=$form->GetHTML(array('class'=>'content-edit'))?>

<h2>All persons</h2>
<?php if($contents != null):?>
  <ul>
  <?php foreach($contents as $val):?>
    <li><?=$val['id']?>, <?=$val['name']?> <a href='<?=create_url("testbook/index/{$val['id']}")?>'>View person</a>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>No content exists.</p>
<?php endif;?>

