<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$profile = get_profile();
$services = active_services();
$pageTitle = page_title('Contact');
$error = null;
$old = ['name' => '', 'email' => '', 'phone' => '', 'service' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $old = [
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => trim((string) ($_POST['email'] ?? '')),
        'phone' => trim((string) ($_POST['phone'] ?? '')),
        'service' => trim((string) ($_POST['service'] ?? '')),
        'message' => trim((string) ($_POST['message'] ?? '')),
    ];

    if (!empty($_POST['company'])) {
        flash('success', 'Thank you. Your message was received.');
        redirect('contact.php');
    }

    $recent = array_filter($_SESSION['contact_times'] ?? [], static fn ($time) => $time > time() - 3600);
    if (count($recent) >= 5) {
        $error = 'Please wait a while before you send another message.';
    } else {
        try {
            $name = required_text($old['name'], 'Name', 150, 2);
            $email = valid_email($old['email']);
            $phone = optional_phone($old['phone']);
            $allowed = array_column($services, 'title');
            $allowed[] = 'General inquiry';
            if (!in_array($old['service'], $allowed, true)) {
                throw new InvalidArgumentException('Choose a service from the list.');
            }
            $message = required_text($old['message'], 'Message', 5000, 10);
            $statement = db()->prepare('INSERT INTO messages (name, email, phone, service, message) VALUES (?, ?, ?, ?, ?)');
            $statement->execute([$name, $email, $phone, $old['service'], $message]);
            $_SESSION['contact_times'] = array_values($recent);
            $_SESSION['contact_times'][] = time();
            flash('success', 'Thank you. Your message was received.');
            redirect('contact.php');
        } catch (InvalidArgumentException $exception) {
            $error = $exception->getMessage();
        }
    }
}

require __DIR__ . '/includes/header.php';
?>
<header class="page-head">
  <div class="container">
    <p class="eyebrow">Contact</p>
    <h1>Contact me.</h1>
    <p class="lead-text">Send a message about a website, a lesson, or help with technology.</p>
  </div>
</header>
<section class="section pt-0">
  <div class="container contact-grid">
    <aside class="panel">
      <h2>Reach me</h2>
      <?php if (!empty($profile['email'])): ?><p><a href="mailto:<?= e($profile['email']) ?>"><?= e($profile['email']) ?></a></p><?php endif; ?>
      <?php if (!empty($profile['phone'])): ?><p><?= e($profile['phone']) ?></p><?php endif; ?>
      <?php if (!empty($profile['location'])): ?><p class="muted"><?= e($profile['location']) ?></p><?php endif; ?>
      <?php if ($wa = whatsapp_link((string) ($profile['whatsapp'] ?? ''))): ?>
        <a class="btn btn-glow" href="<?= e($wa) ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a>
      <?php endif; ?>
      <?php if (empty($profile['email']) && empty($profile['phone']) && empty($profile['whatsapp']) && empty($profile['location'])): ?>
        <p class="muted mb-0">Use the form to send a message.</p>
      <?php endif; ?>
    </aside>
    <form class="panel" method="post" action="contact.php" novalidate>
      <?= csrf_field() ?>
      <div class="hp-field">
        <label>Leave this empty<input type="text" name="company" tabindex="-1" autocomplete="off"></label>
      </div>
      <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
      <div class="mb-3">
        <label class="form-label" for="name">Name</label>
        <input class="form-control" id="name" name="name" required maxlength="150" value="<?= e($old['name']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" id="email" name="email" type="email" required maxlength="190" value="<?= e($old['email']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="phone">Phone</label>
        <input class="form-control" id="phone" name="phone" maxlength="40" value="<?= e($old['phone']) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label" for="service">Service</label>
        <select class="form-select" id="service" name="service" required>
          <option value="">Choose one</option>
          <option value="General inquiry"<?= $old['service'] === 'General inquiry' ? ' selected' : '' ?>>General question</option>
          <?php foreach ($services as $service): ?>
            <option value="<?= e($service['title']) ?>"<?= $old['service'] === $service['title'] ? ' selected' : '' ?>><?= e($service['title']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label" for="message">Message</label>
        <textarea class="form-control" id="message" name="message" rows="6" required><?= e($old['message']) ?></textarea>
      </div>
      <button class="btn btn-glow" type="submit">Send message</button>
    </form>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
