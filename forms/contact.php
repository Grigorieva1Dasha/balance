<form action="<?= $url ?>" method="post">

  <label>Номер</label><br>
  <input type="text" name="number" value="<?= !empty($contact['number']) ? $contact['number'] : ""?>"><br>
  <label>Баланс</label><br>
  <input  type="text" name="money" value="<?= !empty($contact['money']) ? $contact['money'] : ""?>"><br>
  <br>
  <button type="submit">Сохранить</button>
  <button type="button" onclick="window.location='/index.php?function=clients'">Назад</button>

</form>
