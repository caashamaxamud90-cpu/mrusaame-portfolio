<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = page_title('Services');
$services = active_services();
require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <p class="eyebrow">Services</p>
    <h1>How I can help.</h1>
  </div>
</header>
<section class="section pt-0">
  <div class="container">
    <div class="card-grid">
      <?php foreach ($services as $service): ?>
        <article class="service-card reveal">
          <?php $poster = video_poster($service['video_url'] ?? '', $service['title']); ?>
          <?php if ($poster !== ''): ?>
            <?= $poster ?>
          <?php else: ?>
            <i class="bi <?= e($service['icon']) ?>"></i>
          <?php endif; ?>
          <h2 class="h3 mt-3"><?= e($service['title']) ?></h2>
          <p class="muted"><?= nl2br(e($service['description'])) ?></p>
          <?php if (!empty($service['video_url'])): ?>
            <a class="btn btn-glow" href="<?= e($service['video_url']) ?>" target="_blank" rel="noopener noreferrer">Watch lesson</a>
          <?php else: ?>
            <a class="btn btn-line" href="<?= e(url('contact.php')) ?>">Ask about this</a>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
