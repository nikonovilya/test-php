<?php
function handleVisitCount(): string {
  $cookieName = 'visit_count';
  $visitCount = 1;

  if (isset($_COOKIE[$cookieName])) {
    $visitCount = (int)$_COOKIE[$cookieName] + 1;
  }

  // Обновляем куку на 30 дней
  setcookie($cookieName, (string)$visitCount, time() + 60 * 60 * 24 * 30, "/");

  if ($visitCount === 1) {
    return "Это ваш первый визит на страницу!";
  } else {
    return "Вы были на этой странице {$visitCount} " . pluralForm($visitCount, 'раз', 'раза', 'раз');
  }
}

function pluralForm($n, $one, $few, $many) {
  $n = abs($n) % 100;
  $n1 = $n % 10;
  if ($n > 10 && $n < 20) return $many;
  if ($n1 > 1 && $n1 < 5) return $few;
  if ($n1 == 1) return $one;
  return $many;
}
