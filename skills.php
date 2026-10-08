<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = page_title('Skills');
$skills = active_skills();
require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <p class="eyebrow">Skills</p>
    <h1>What I teach and use.</h1>
    <p class="lead-text">Common tools and subjects used around the world.</p>
  </div>
</header>
<section class="section pt-0">
  <div class="container">
    <?php if (!$skills): ?>
      <p class="muted">No skills are published yet.</p>
    <?php else: ?>
      <div class="skill-grid">
        <?php foreach ($skills as $skill): ?>
          <article class="skill-card reveal"><strong><?= e($skill['name']) ?></strong><?php if (!empty($skill['detail'])): ?><p class="muted"><?= e($skill['detail']) ?></p><?php endif; ?></article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
