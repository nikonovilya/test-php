<?php
$postsTitle = 'Posts';
$filterLabel = 'Filter by user:';
$allUsersLabel = 'All users';
$userLabel = 'User';
$noPostsMessage = 'No posts to display.';

function getPosts(?int $userId = null): array {
  $url = 'https://jsonplaceholder.typicode.com/posts';
  $json = @file_get_contents($url);

  if ($json === false) {
    return [];
  }

  $allPosts = json_decode($json, true);
  if (!is_array($allPosts)) {
    return [];
  }

  $allPosts = array_slice($allPosts, 0, 12);

  if ($userId === null) {
    return $allPosts;
  }

  $chunks = array_chunk($allPosts, 4); // делим на 3 части по 4 поста
  return $chunks[$userId - 1] ?? [];
}

function renderUserFilter(?int $activeUserId = null, string $label = 'Filter by user:', string $allUsersText = 'All users', string $userText = 'User'): void {
  ?>
  <form class="posts__filter" method="get">
    <label for="user"><?= htmlspecialchars($label) ?></label>
    <select name="user" id="user" onchange="this.form.submit()">
      <option value="all" <?= $activeUserId === null ? 'selected' : '' ?>><?= htmlspecialchars($allUsersText) ?></option>
      <?php for ($i = 1; $i <= 3; $i++): ?>
        <option value="<?= $i ?>" <?= $activeUserId === $i ? 'selected' : '' ?>>
          <?= htmlspecialchars($userText . ' ' . $i) ?>
        </option>
      <?php endfor; ?>
    </select>
  </form>
  <?php
}

function renderPostList(array $posts, string $noPostsText = 'No posts to display.'): void {
  if (empty($posts)) {
    echo "<p class='posts__empty'>" . htmlspecialchars($noPostsText) . "</p>";
    return;
  }
  ?>
  <ul class="posts__list">
    <?php foreach ($posts as $post): ?>
      <li class="posts__item">
        <div class="post__item-image">
          <img src="https://picsum.photos/id/<?= $post['id'] + 10 ?>/400/250" alt="Post image">
        </div>
        <h3 class="post__item-title"><?= htmlspecialchars($post['title']) ?></h3>
        <p class="post__item-text"><?= nl2br(htmlspecialchars($post['body'])) ?></p>
      </li>
    <?php endforeach; ?>
  </ul>
  <?php
}

function renderPostsSection(array $posts, ?int $userId): void {
  global $postsTitle, $filterLabel, $allUsersLabel, $userLabel, $noPostsMessage;
  ?>
  <section class="posts">
    <div class="container">
      <div class="posts__wrapper">
        <h2 class="title posts__title"><?= htmlspecialchars($postsTitle) ?></h2>
        <?php renderUserFilter($userId, $filterLabel, $allUsersLabel, $userLabel); ?>
        <?php renderPostList($posts, $noPostsMessage); ?>
      </div>
    </div>
  </section>
  <?php
}
