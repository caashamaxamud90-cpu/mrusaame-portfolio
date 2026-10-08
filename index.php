<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$profile = get_profile();
$settings = get_settings();
$pageTitle = page_title();
$projects = published_projects(6);
$testimonials = published_testimonials();
$youtubeUrl = $settings['youtube_url'] ?: ($profile['youtube'] ?? '');

require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <p class="eyebrow"><?= e($profile['brand']) ?></p>
        <h1><?= e($profile['name']) ?></h1>
        <p class="eyebrow mt-3"><?= e($settings['hero_subtitle']) ?></p>
        <h2><?= e($settings['hero_title']) ?></h2>
        <p class="lead-text"><?= e($settings['hero_description']) ?></p>
        <div class="d-flex flex-wrap gap-2 mt-4">
          <a class="btn btn-glow" href="<?= e(url('projects.php')) ?>">See the lessons</a>
          <a class="btn btn-line" href="<?= e(url('contact.php')) ?>">Contact me</a>
          <?php if (!empty($profile['github'])): ?>
            <a class="btn btn-line" href="<?= e($profile['github']) ?>" target="_blank" rel="noopener noreferrer"><i class="bi bi-github"></i> GitHub</a>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="portrait">
          <?php if ($photo = media_url($profile['profile_image'] ?? null)): ?>
            <img src="<?= e($photo) ?>" alt="Portrait of <?= e($profile['name']) ?>">
          <?php else: ?>
            <div class="portrait-fallback">
              <span><?= e(initials($profile['name'])) ?></span>
              <p class="px-4">Profile photo can be added from the admin dashboard.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section pt-0">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-5 reveal">
        <figure class="story-photo">
          <img src="<?= e(media_url('ismaaciil-formal.jpg')) ?>" alt="<?= e($profile['name']) ?> in a formal portrait">
        </figure>
      </div>
      <div class="col-lg-7 reveal">
        <p class="eyebrow">About</p>
        <h2>Lessons, websites, and technology.</h2>
        <p class="muted"><?= e($profile['short_bio']) ?></p>
        <p class="mb-4"><?= e($profile['professional_title']) ?></p>
        <a class="btn btn-line" href="<?= e(url('about.php')) ?>">Read more</a>
      </div>
    </div>
  </div>
</section>

<section class="section pt-0">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
      <div>
        <p class="eyebrow">Learn Technology in Somali</p>
        <h2>Lessons I have made.</h2>
      </div>
      <a href="<?= e(url('projects.php')) ?>">All lessons</a>
    </div>
    <div class="card-grid">
      <?php foreach ($projects as $project): ?>
        <article class="work-card reveal">
          <?= cover_markup($project['image'], $project['title'], $project['project_url'] ?? '') ?>
          <p class="eyebrow"><?= e($project['category']) ?></p>
          <h3><?= e($project['title']) ?></h3>
          <p class="muted"><?= e($project['description']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section pt-0">
  <div class="container">
    <div class="promo reveal">
      <p class="eyebrow"><?= e($profile['brand']) ?></p>
      <h2><?= e($settings['youtube_heading']) ?></h2>
      <p class="muted"><?= e($settings['youtube_description']) ?></p>
      <div class="video-frame mt-3">
        <iframe class="playlist-embed" src="https://www.youtube-nocookie.com/embed/videoseries?list=UUA_8E2iUNJ7KanmK0wKhoJA" title="Learn Technology in Somali" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
      </div>
      <?php if ($youtubeUrl): ?>
        <a class="btn btn-glow mt-3" href="<?= e($youtubeUrl) ?>" target="_blank" rel="noopener noreferrer">Watch the channel</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if ($testimonials): ?>
<section class="section pt-0">
  <div class="container">
    <p class="eyebrow">Reviews</p>
    <h2>What people say.</h2>
    <div class="card-grid">
      <?php foreach ($testimonials as $item): ?>
        <blockquote class="quote-card reveal">
          <?php if ((int) $item['is_sample'] === 1): ?><span class="sample-flag">Sample placeholder</span><?php endif; ?>
          <p><?= nl2br(e($item['message'])) ?></p>
          <footer><strong><?= e($item['client_name']) ?></strong><br><span class="muted"><?= e($item['role_title']) ?></span></footer>
        </blockquote>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section pt-0" id="websites">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end gap-3 mb-4">
      <div>
        <p class="eyebrow">GitHub</p>
        <h2>Websites I built for Eng. Ismaaciil.</h2>
        <p class="muted mb-0">Three are front only. Four have a front and a back.</p>
      </div>
      <?php if (!empty($profile['github'])): ?>
        <a class="btn btn-glow" href="<?= e($profile['github']) ?>" target="_blank" rel="noopener noreferrer"><i class="bi bi-github"></i> GitHub</a>
      <?php endif; ?>
    </div>
    <div class="card-grid">
      <?php foreach (db()->query("SELECT * FROM projects WHERE is_published = 1 AND category IN ('GitHub', 'Front', 'Full stack') ORDER BY sort_order")->fetchAll() as $app): ?>
        <article class="work-card reveal">
          <p class="eyebrow"><?= e($app['technologies']) ?></p>
          <h3><?= e($app['title']) ?></h3>
          <p class="muted"><?= e($app['description']) ?></p>
          <div class="d-flex gap-3">
            <?php if (!empty($app['project_url'])): ?>
              <a href="<?= e(url($app['project_url'])) ?>">Open site</a>
            <?php endif; ?>
            <?php if (!empty($app['github_url'])): ?>
              <a href="<?= e($app['github_url']) ?>" target="_blank" rel="noopener noreferrer">GitHub</a>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section pt-0">
  <div class="container">
    <div class="promo reveal">
      <h2><?= e($settings['promo_title']) ?></h2>
      <p class="muted"><?= e($settings['promo_text']) ?></p>
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-glow" href="<?= e(url('contact.php')) ?>">Contact me</a>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
