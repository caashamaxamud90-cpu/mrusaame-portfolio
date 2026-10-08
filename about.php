<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$profile = get_profile();
$pageTitle = page_title('About');
$sections = [
    'About me' => $profile['about_text'] ?? '',
    'Education' => $profile['education_text'] ?? '',
    'Technology interests' => $profile['interests_text'] ?? '',
    'Teaching' => $profile['teaching_text'] ?? '',
    'Web development' => $profile['web_text'] ?? '',
    'AI' => $profile['ai_text'] ?? '',
    'Digital skills' => $profile['digital_skills_text'] ?? '',
];

require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-5">
        <figure class="story-photo">
          <img src="<?= e(media_url('ismaaciil-formal.jpg')) ?>" alt="<?= e($profile['name']) ?> standing in a formal portrait">
        </figure>
      </div>
      <div class="col-lg-7">
        <p class="eyebrow">About</p>
        <h1><?= e($profile['name']) ?></h1>
        <p class="lead-text"><?= e($profile['professional_title']) ?></p>
      </div>
    </div>
  </div>
</header>
<section class="section pt-0">
  <div class="container" style="max-width: 860px;">
    <?php foreach ($sections as $heading => $text): ?>
      <?php if (trim((string) $text) === '') { continue; } ?>
      <article class="panel about-block reveal">
        <h2><?= e($heading) ?></h2>
        <p class="muted mb-0"><?= nl2br(e($text)) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
