<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = page_title('Projects');
$projects = published_projects();
require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <p class="eyebrow">Learn Technology in Somali</p>
    <h1>Lessons I have made.</h1>
    <p class="lead-text">These are the most watched lessons, grouped by topic.</p>
  </div>
</header>
<section class="section pt-0">
  <div class="container">
    <?php
    $groups = [];
    foreach ($projects as $project) {
        $name = trim((string) ($project['category'] ?? ''));
        if ($name === '' || $name === 'Full stack' || $name === 'Front' || $name === 'GitHub') {
            continue;
        }
        $groups[$name][] = $project;
    }
    ?>
    <?php foreach ($groups as $name => $items): ?>
      <?php $anchor = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $name), '-')); ?>
      <div class="d-flex justify-content-between align-items-end gap-3 mb-4<?= $name === array_key_first($groups) ? '' : ' mt-5' ?>" id="<?= e($anchor) ?>">
        <div>
          <p class="eyebrow">Lessons</p>
          <h2><?= e($name) ?></h2>
        </div>
      </div>
      <div class="card-grid">
        <?php foreach ($items as $project): ?>
          <article class="work-card reveal">
            <?= cover_markup($project['image'], $project['title'], $project['project_url'] ?? '') ?>
            <h3><?= e($project['title']) ?></h3>
            <p class="muted"><?= nl2br(e($project['description'])) ?></p>
            <?php if (!empty($project['technologies'])): ?>
              <div class="tags">
                <?php foreach (array_filter(array_map('trim', explode(',', (string) $project['technologies']))) as $tag): ?>
                  <span class="tag"><?= e($tag) ?></span>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($project['project_url'])): ?>
              <a href="<?= e($project['project_url']) ?>" target="_blank" rel="noopener noreferrer">Watch lesson</a>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
