<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
$profile = get_profile();
$settings = get_settings();
$pageTitle = page_title('YouTube');
$youtubeUrl = $settings['youtube_url'] ?: ($profile['youtube'] ?? '');
require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <p class="eyebrow"><?= e($profile['brand']) ?></p>
    <h1><?= e($settings['youtube_heading']) ?></h1>
    <p class="lead-text"><?= e($settings['youtube_description']) ?></p>
    <div class="video-frame mt-4">
      <iframe class="playlist-embed" src="https://www.youtube-nocookie.com/embed/videoseries?list=UUA_8E2iUNJ7KanmK0wKhoJA" title="<?= e($settings['youtube_heading']) ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
    </div>
    <?php if ($youtubeUrl): ?>
      <a class="btn btn-glow mt-3" href="<?= e($youtubeUrl) ?>" target="_blank" rel="noopener noreferrer">Watch the channel</a>
    <?php endif; ?>
  </div>
</header>
<section class="section pt-0">
  <div class="container">
    <div class="card-grid">
      <?php foreach (published_projects() as $project): ?>
        <?php if (youtube_id($project['project_url'] ?? '') || youtube_playlist_id($project['project_url'] ?? '')): ?>
          <article class="work-card reveal">
            <?= cover_markup($project['image'], $project['title'], $project['project_url']) ?>
            <h2 class="h3"><?= e($project['title']) ?></h2>
            <p class="muted"><?= e($project['description']) ?></p>
          </article>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
