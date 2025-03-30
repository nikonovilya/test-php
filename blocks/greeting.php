<?php
function getGreeting(): string
{
  $hour = (int)date('H');

  if ($hour >= 5 && $hour < 12) {
    return 'Доброе утро';
  } elseif ($hour >= 12 && $hour < 18) {
    return 'Добрый день';
  } elseif ($hour >= 18 && $hour < 23) {
    return 'Добрый вечер';
  } else {
    return 'Доброй ночи';
  }
}

function renderGreetingBlock(
  string $pageTitle,
  string $greeting,
  string $currentDate,
  string $visitMessage
): void
{
  ?>
  <section class="greeting">
    <div class="container">
      <div class="greeting__wrapper">
        <h1 class="title greeting__title"><?= htmlspecialchars($pageTitle) ?></h1>
        <p class="greeting__date"><?= $greeting ?>! Сегодня: <?= $currentDate ?></p>
        <p class="greeting__visit"><?= $visitMessage ?></p>
      </div>
    </div>
  </section>
  <?php
}
