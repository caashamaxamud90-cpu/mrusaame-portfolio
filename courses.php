<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = page_title('Courses');
$courses = published_courses();
require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <p class="eyebrow">Courses</p>
    <h1>Course lessons.</h1>
  </div>
</header>
<section class="section pt-0">
  <div class="container">
    <?php
    $groups = [];
    foreach ($courses as $course) {
        $name = trim((string) ($course['level'] ?? ''));
        if ($name === '') {
            $name = 'Courses';
        }
        $groups[$name][] = $course;
    }
    ?>
    <?php foreach ($groups as $name => $items): ?>
      <?php $anchor = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $name), '-')); ?>
      <div class="d-flex justify-content-between align-items-end gap-3 mb-4<?= $name === array_key_first($groups) ? '' : ' mt-5' ?>" id="<?= e($anchor) ?>">
        <div>
          <p class="eyebrow">Courses</p>
          <h2><?= e($name) ?></h2>
        </div>
      </div>
      <div class="card-grid">
        <?php foreach ($items as $course): ?>
          <?php $watch = (string) ($course['enroll_url'] ?? ''); ?>
          <article class="course-card reveal">
            <?= cover_markup($course['image'], $course['title'], $watch) ?>
            <h3><?= e($course['title']) ?></h3>
            <p class="muted"><?= nl2br(e($course['description'])) ?></p>
            <?php if ($watch !== ''): ?>
              <a class="btn btn-glow" href="<?= e(link_href($watch)) ?>"<?= is_external($watch) ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= youtube_id($watch) || youtube_playlist_id($watch) ? 'Watch lesson' : 'Ask about this course' ?></a>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
