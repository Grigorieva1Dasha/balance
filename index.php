<?php
#var $pdo;
$pdo = new PDO('mysql:host=localhost;dbname=agicontact', 'root', '');  
$pdo->exec("set names utf8");

if (isset($_GET['action'])){
  switch ($_GET['action']){
    case 'add':
      $contacts = $pdo->query('SELECT * FROM `contacts`');
      $url = '/?action=create';
      include 'forms/contact.php';
    break;

    case 'create':
      $sql = $pdo->prepare('INSERT INTO `contacts` (`number`, `money`) VALUES (:number, :money)');
      $sql->execute([
        ':number' => $_POST['number'],
        ':money' => $_POST['money']
      ]);
      echo 'Новый клиент добавлен успешно!<br><br><a href="/?">Назад</a>';
    break;
    
    case 'edit':
      $sql = $pdo->prepare('SELECT * FROM `contacts` WHERE `id` = :id');
      $sql->execute([':id' => $_GET['id']]);
      $contact = $sql->fetch();
      $url = '/?action=update&id=' . $_GET['id'];
      include 'forms/contact.php';
    break;
    
    case 'update':
      $sql = $pdo->prepare('UPDATE `contacts` SET `number` = :number, `money` = :money WHERE `id` = :id LIMIT 1');
      $sql->execute([
        ':id' => $_GET['id'],
        ':number' => $_POST['number'],
        ':money' => $_POST['money']
      ]);
      echo 'Данные о клиенте успешно обновлены!<br><br><a href="/?" >Назад</a>';
    break;

    case 'delete':
      $sql = $pdo->prepare('DELETE FROM `contacts` WHERE `id` = :id LIMIT 1');
      $sql->execute([':id' => $_GET['id']]);
      echo 'Данные о клиенте удалены!<br><br><a href="/?">Назад</a>';
    break;
  }
}
else{
    $contacts = $pdo->query('
      SELECT 
        `id`, 
        `number`,
        `money`
      FROM 
        `contacts`
      ');

    echo '<table border="1" cellspacing="0">';

    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Телефон</th>';
    echo '<th>Баланс</th>';
    echo '<th>&nbsp;</th>';
    echo '<th>&nbsp;</th>';
    echo '</tr>';

    foreach ($contacts as $client)
    {
      echo '<tr>';
      echo '<td>' . $client['id'] . '</td> ' 
      . '<td>' .$client['number']. '</td> ' 
      . '<td>' . $client['money'] . '</td> '
      . '<td><a href="/?action=edit&id=' . $client['id'] . '">ред.</td>'
      . '<td></a> <a href="/?action=delete&id=' . $client['id'] . '">уд.</a></td>';
      echo '</tr>';

    }
    echo '</table>';
    echo '<a href="/?action=add">Добавить</a><br>';
}