<?php
$pageTitle = 'Test PHP';
date_default_timezone_set('Europe/Moscow');

// Подключаем модули
require_once 'blocks/greeting.php';
require_once 'blocks/visits.php';
require_once 'blocks/posts.php';
require_once 'blocks/form.php';

// Приветствие и дата
$greeting = getGreeting();
$formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
$currentDate = $formatter->format(time());

// Счётчик посещений
$visitMessage = handleVisitCount();

// Обработка фильтра userId
$userId = isset($_GET['user']) && $_GET['user'] !== 'all' ? (int) $_GET['user'] : null;
$posts = getPosts($userId);

// Обработка формы
$formResponse = handleFormSubmission();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
<div class="page-wrapper">
  <main>
    <?php renderGreetingBlock($pageTitle, $greeting, $currentDate, $visitMessage); ?>
    <?php renderPostsSection($posts, $userId); ?>
    <?php renderForm($formResponse); ?>
  </main>
</div>
</body>
</html>
