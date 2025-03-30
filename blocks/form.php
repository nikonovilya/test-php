<?php
$formTitle = 'Contact Form';
$successMessage = 'Form submitted successfully!';
$errorMessage = 'There was an error submitting the form.';
$submitButtonText = 'Send';
$okButtonText = 'OK';

$namePlaceholder = 'Your name';
$nameTitle = 'Please enter at least 2 letters (A-Z, a-z, А-Я, а-я)';
$nameError = 'Name must contain at least 2 letters and only letters (A-Z, a-z, А-Я, а-я)';

$emailPlaceholder = 'Email';
$emailTitle = 'Please enter a valid email address';
$emailError = 'Valid email is required (e.g. name@example.com)';

$messagePlaceholder = 'Message';
$messageTitle = 'Minimum 10 characters required';
$messageError = 'Message must be at least 10 characters long';

$externalError = 'Failed to send data to Google Sheets.';

function validateFormData(array $data): array
{
  global $nameError, $emailError, $messageError;

  $errors = [];

  if (empty($data['name']) || !preg_match('/^[A-Za-zА-Яа-яЁё]{2,}$/u', $data['name'])) {
    $errors[] = $nameError;
  }

  if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = $emailError;
  }

  if (empty($data['message']) || mb_strlen($data['message']) < 10) {
    $errors[] = $messageError;
  }

  return $errors;
}

function handleFormSubmission(): array
{
  global $externalError;

  $response = [
    'success' => false,
    'errors' => [],
    'data' => [],
    'submitted' => false
  ];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response['submitted'] = true;

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $formName = trim($_POST['form-name'] ?? '');

    $formData = [
      'name' => $name,
      'email' => $email,
      'message' => $message,
      'form-name' => $formName,
      'date' => date('Y-m-d'),
      'time' => date('H:i')
    ];

    $errors = validateFormData($formData);

    if (empty($errors)) {
      $googleApiUrl = 'https://script.google.com/macros/s/AKfycbyFxCrdIDALeZYWBnpicVw8fWC28ay7p9HGoM_KwnoVkmqqJeMKxUQfMGMuC0_FzVLSow/exec2';

      $options = [
        'http' => [
          'header' => "Content-type: application/x-www-form-urlencoded",
          'method' => 'POST',
          'content' => http_build_query($formData)
        ]
      ];

      $context = stream_context_create($options);
      $result = @file_get_contents($googleApiUrl, false, $context);

      if ($result !== false) {
        $response['success'] = true;
        $response['data'] = $formData;
      } else {
        $response['errors'][] = $externalError;
      }
    } else {
      $response['errors'] = $errors;
    }
  }

  return $response;
}

function renderForm(array $response): void
{
  global $formTitle, $successMessage, $errorMessage, $submitButtonText, $okButtonText,
         $namePlaceholder, $nameTitle, $emailPlaceholder, $emailTitle,
         $messagePlaceholder, $messageTitle;

  $success = $response['success'];
  $errors = $response['errors'];
  $data = $response['data'];
  $submitted = $response['submitted'];
  ?>

  <section class="form">
    <div class="container">
      <div class="form__wrapper">
        <h2 class="title form__title"><?= htmlspecialchars($formTitle) ?></h2>

        <?php if ($submitted && ($success || !empty($errors))): ?>
          <div class="form__message form__message--<?= $success ? 'success' : 'error' ?>">
            <p><?= $success ? $successMessage : $errorMessage ?></p>
            <?php if (!$success && !empty($errors)): ?>
              <ul>
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="btn form__message-btn">
              <?= htmlspecialchars($okButtonText) ?>
            </a>
          </div>
        <?php else: ?>
          <form class="form__content" method="post" novalidate>
            <input type="hidden" name="form-name" value="ContactForm">

            <input
              type="text"
              name="name"
              class="form__input"
              placeholder="<?= htmlspecialchars($namePlaceholder) ?>"
              value="<?= htmlspecialchars($data['name'] ?? '') ?>"
              required
              maxlength="100"
              pattern="^[A-Za-zА-Яа-яЁё]{2,}$"
              title="<?= htmlspecialchars($nameTitle) ?>"
            >

            <input
              type="email"
              name="email"
              class="form__input"
              placeholder="<?= htmlspecialchars($emailPlaceholder) ?>"
              value="<?= htmlspecialchars($data['email'] ?? '') ?>"
              required
              pattern="^[^\s@]+@[^\s@]+\.[^\s@]{2,}$"
              title="<?= htmlspecialchars($emailTitle) ?>"
            >

            <textarea
              name="message"
              class="form__input"
              placeholder="<?= htmlspecialchars($messagePlaceholder) ?>"
              required
              minlength="10"
              maxlength="150"
              title="<?= htmlspecialchars($messageTitle) ?>"
            ><?= htmlspecialchars($data['message'] ?? '') ?></textarea>

            <button type="submit" class="btn form__submit"><?= htmlspecialchars($submitButtonText) ?></button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php
}
