<?php
/**
 * Dynamic Country Template
 * Fetches data from the database based on the 'id' parameter.
 */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/services/ContentService.php';

$conn = getDBConnection();
$contentService = new ContentService($conn);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$country = $contentService->getCountry($id);

if (!$country || $country->status !== 'published') {
    http_response_code(404);
    echo "<h1>Page Not Found</h1><p>The country page you are looking for is not available.</p>";
    exit;
}

$page_title = $country->meta_title ?: $country->country_name . " Transfer Pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($country->meta_description ?? ''); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-deep: #0a0e17;
            --card-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --accent: #f5c400;
            --text-slate: #94a3b8;
        }

        body {
            background-color: var(--bg-deep);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            padding: 100px 0;
            background: radial-gradient(circle at top right, rgba(245, 196, 0, 0.05), transparent);
        }

        .section-title {
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 800;
            margin-bottom: 40px;
        }

        .card-box {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            transition: 0.3s;
        }

        .framework-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .doc-accordion-item {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
        }

        .doc-accordion-header {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .doc-accordion-header:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .doc-accordion-content {
            padding: 0 20px 20px;
            display: none;
            color: var(--text-slate);
        }

        .cta {
            padding: 80px 0;
            text-align: center;
            background: linear-gradient(rgba(10, 14, 23, 0.8), rgba(10, 14, 23, 0.8)), url('assets/img/cta-bg.jpg');
            background-size: cover;
        }

        .btn-accent {
            background: var(--accent);
            color: #000;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 8px;
        }

        footer {
            padding: 50px 0;
            border-top: 1px solid var(--glass-border);
        }
    </style>
</head>
<body>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1><?php echo nl2br(htmlspecialchars($country->hero_title ?? '')); ?></h1>
                    <p><?php echo nl2br(htmlspecialchars($country->hero_description ?? '')); ?></p>
                    <a href="#consult" class="btn btn-accent mt-3">Book Free Consultation</a>
                </div>
                <div class="col-lg-6 text-center">
                    <?php if ($country->flag_url): ?>
                        <img src="<?php echo htmlspecialchars($country->flag_url); ?>" class="img-fluid rounded shadow-lg" style="max-height: 250px; border: 1px solid var(--glass-border);">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php if ($country->overview): ?>
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Overview</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 card-box h-100">
                        <?php echo $country->overview->overview_text_left; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 card-box h-100">
                        <?php echo $country->overview->overview_text_right; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($country->regulatory_frameworks)): ?>
    <section class="py-5" style="background: rgba(255,255,255,0.02);">
        <div class="container">
            <h2 class="section-title text-center">Key Regulatory Frameworks</h2>
            <div class="row g-4">
                <?php foreach ($country->regulatory_frameworks as $fw): ?>
                <div class="col-md-4">
                    <div class="p-4 card-box framework-card h-100">
                        <h4 class="text-warning mb-3"><?php echo htmlspecialchars($fw->title); ?></h4>
                        <div class="text-slate"><?php echo $fw->description; ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($country->documentation_cards)): ?>
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">TP Documentation Requirements</h2>
            <div class="accordion-custom">
                <?php foreach ($country->documentation_cards as $index => $card): ?>
                <div class="doc-accordion-item">
                    <div class="doc-accordion-header" onclick="toggleAccordion(<?php echo $index; ?>)">
                        <h5 class="mb-0"><?php echo htmlspecialchars($card->title); ?></h5>
                        <i class="bi bi-plus-lg" id="icon<?php echo $index; ?>"></i>
                    </div>
                    <div class="doc-accordion-content" id="content<?php echo $index; ?>">
                        <div class="mb-3 p-2 border-bottom border-secondary" style="font-style: italic;">
                            <?php echo htmlspecialchars($card->short_description); ?>
                        </div>
                        <div class="detailed-content">
                            <?php echo $card->detailed_content; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="cta" id="consult">
        <div class="container">
            <h2>Seeking TP Advisory in <?php echo htmlspecialchars($country->country_name); ?>?</h2>
            <p style="color:var(--text-slate)">Navigate the complex TP landscape with our specialized local expertise and benchmarking solutions.</p>
            <a href="mailto:md@hexatp.com" class="btn btn-accent mt-3">Contact Team</a>
        </div>
    </section>

    <footer>
        <div class="container text-center">
            <p>&copy; <?php echo date('Y'); ?> HexaTP. All rights reserved.</p>
            <?php if ($country && $country->updated_at): ?>
            <p style="font-size: 0.8rem; color: var(--text-slate); margin-top: 10px;">
                <i class="bi bi-clock-history me-1"></i> Last Updated: <?php echo $country->updated_at->format('M d, Y H:i'); ?>
            </p>
            <?php endif; ?>
        </div>
    </footer>

    <script>
        function toggleAccordion(index) {
            const content = document.getElementById('content' + index);
            const icon = document.getElementById('icon' + index);
            const allContents = document.querySelectorAll('.doc-accordion-content');
            const allIcons = document.querySelectorAll('.doc-accordion-header i');

            allContents.forEach((c, i) => {
                if (i !== index) {
                    c.style.display = 'none';
                    allIcons[i].className = 'bi bi-plus-lg';
                }
            });

            if (content.style.display === 'block') {
                content.style.display = 'none';
                icon.className = 'bi bi-plus-lg';
            } else {
                content.style.display = 'block';
                icon.className = 'bi bi-dash-lg';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
