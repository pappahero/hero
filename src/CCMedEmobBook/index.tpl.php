<h1>MedEmobBoken</h1>
<p>En applikation som hanterar information om människor</p>

<form action="<?=$form_action?>" method='post'>
    <FIELDSET>
    <LABEL for="name">Name: </LABEL><BR>
    <INPUT type="text" name="name" value="Henrik" size="100" maxlength="50" tabindex="1"><BR><BR>
    <LABEL for="telNr">Telefonnummer: </LABEL><BR>
    <INPUT type="text" name="telNr" value="070-606 48 77" size="100" maxlength="50" tabindex="2"><BR><BR>
    <LABEL for="email">email: </LABEL><BR>
    <INPUT type="text" name="mail" value="henrikroden@gmail.com" size="100" maxlength="50" tabindex="3"><BR><BR>
    </FIELDSET>
  <p>
    <input type='submit' name='doAdd' value='Add person' />
    <input type='submit' name='doClear' value='Clear all personinformation' />
    <input type='submit' name='doCreate' value='Create database table' />
  </p>
</form>

<h2>Current messages</h2>

<?php foreach($entries as $val):?>
<div style='background-color:#f6f6f6; border:1px solid #ccc; margin-bottom:1em;
padding:1em;'>
  <p>At: <?=$val['created']?></p>
<p><?=htmlent($val['name'])?></p>
<p><?=htmlent($val['telNr'])?></p>
<p><?=htmlent($val['mail'])?></p>
</div>
<?php endforeach;?>
