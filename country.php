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

$page_title = $country->meta_title ?: $country->country_name . " Transfer Pricing | HexaTP";
$meta_description = $country->meta_description ?? '';

// Include Global Header
include 'includes/header.php';
?>

<style>
    /* Premium overrides for dynamic content */
    .hero {
        padding: 160px 0 100px;
        background: radial-gradient(circle at top right, rgba(245, 196, 0, 0.1), transparent);
        border-bottom: 1px solid var(--glass-border);
    }

    .section-title {
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        margin-bottom: 40px;
        position: relative;
        display: inline-block;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--accent);
    }

    .card-box {
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .card-box:hover {
        transform: translateY(-10px);
        border-color: var(--accent);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .doc-accordion-item {
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        margin-bottom: 15px;
        border-radius: 15px;
        overflow: hidden;
        transition: 0.3s;
    }
    .doc-accordion-item:hover {
        border-color: rgba(245, 196, 0, 0.3);
    }

    .doc-accordion-header {
        padding: 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .doc-accordion-content {
        padding: 0 25px 25px;
        display: none;
        color: var(--text-slate);
        border-top: 1px solid var(--glass-border);
        padding-top: 20px;
    }

    .btn-accent {
        background: var(--accent);
        color: #000;
        font-weight: 700;
        padding: 14px 35px;
        border-radius: 100px;
        text-decoration: none;
        display: inline-block;
        transition: 0.3s;
    }
    .btn-accent:hover {
        background: #fff;
        transform: scale(1.05);
    }
</style>

<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-tag" style="background: rgba(245,196,0,0.1); color: var(--accent); padding: 5px 15px; border-radius: 50px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; display: inline-block;">
                    Global Strategic Coverage
                </span>
                <h1 class="display-3 fw-bold mb-4">
                    Transfer Pricing <span class="text-warning"><?php echo htmlspecialchars($country->country_name); ?></span>
                </h1>
                <p class="lead text-slate mb-4" style="font-size: 1.25rem; opacity: 0.9;">
                    <?php 
                    // Use hero_description from DB, or fallback to a default if empty
                    echo nl2br(htmlspecialchars($country->hero_description ?? 'Navigate local tax regulations with our expert advisory and compliance services.')); 
                    ?>
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#consult" class="btn-accent">Get Started</a>
                    <a href="#overview" class="btn btn-outline-light rounded-pill px-4">View Overview</a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-5 mt-lg-0">
                <?php if ($country->flag_url): ?>
                    <div class="position-relative d-inline-block">
                        <img src="<?php echo htmlspecialchars($country->flag_url); ?>" class="img-fluid rounded-4 shadow-lg" style="max-height: 300px; border: 2px solid var(--glass-border); position: relative; z-index: 2;">
                        <div style="position: absolute; top: 20px; right: -20px; width: 100%; height: 100%; background: var(--accent); opacity: 0.1; border-radius: 1rem; z-index: 1;"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if ($country->overview): ?>
<section class="py-5" id="overview">
    <div class="container">
        <h2 class="section-title">Overview</h2>
        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <div class="p-5 card-box h-100">
                    <div class="text-slate" style="font-size: 1.1rem; line-height: 1.8;">
                        <?php echo $country->overview->overview_text_left; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-5 card-box h-100">
                    <div class="text-slate" style="font-size: 1.1rem; line-height: 1.8;">
                        <?php echo $country->overview->overview_text_right; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($country->regulatory_frameworks)): ?>
<section class="py-5" style="background: rgba(255,255,255,0.01);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Key Regulatory Frameworks</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($country->regulatory_frameworks as $fw): ?>
            <div class="col-md-4">
                <div class="p-4 card-box h-100">
                    <div class="mb-3">
                        <i class="bi bi-shield-check text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="text-white mb-3"><?php echo htmlspecialchars($fw->title); ?></h4>
                    <div class="text-slate" style="font-size: 0.95rem; line-height: 1.6;">
                        <?php echo $fw->description; ?>
                    </div>
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
        <div class="mt-5">
            <?php foreach ($country->documentation_cards as $index => $card): ?>
            <div class="doc-accordion-item">
                <div class="doc-accordion-header" onclick="toggleAccordion(<?php echo $index; ?>)">
                    <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($card->title); ?></h5>
                    <i class="bi bi-plus-circle text-warning fs-4" id="icon<?php echo $index; ?>"></i>
                </div>
                <div class="doc-accordion-content" id="content<?php echo $index; ?>">
                    <div class="mb-4 p-3 rounded bg-white bg-opacity-5 border-start border-warning border-3">
                        <span class="text-warning fw-bold">Summary:</span><br>
                        <?php echo htmlspecialchars($card->short_description); ?>
                    </div>
                    <div class="detailed-content text-slate">
                        <?php echo $card->detailed_content; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-5 mt-5" id="consult" style="background: linear-gradient(45deg, #050a14, #102444); border-top: 1px solid var(--glass-border);">
    <div class="container text-center py-4">
        <h2 class="mb-4">Seeking TP Advisory in <?php echo htmlspecialchars($country->country_name); ?>?</h2>
        <p class="text-slate mb-5 mx-auto" style="max-width: 700px;">Our specialized local expertise and benchmarking solutions help you navigate the complex TP landscape with confidence.</p>
        <a href="mailto:md@hexatp.com" class="btn-accent">Schedule a Call with Experts</a>
    </div>
</section>

<script>
    function toggleAccordion(index) {
        const content = document.getElementById('content' + index);
        const icon = document.getElementById('icon' + index);
        const allContents = document.querySelectorAll('.doc-accordion-content');
        const allIcons = document.querySelectorAll('.doc-accordion-header i');

        allContents.forEach((c, i) => {
            if (i !== index) {
                c.style.display = 'none';
                allIcons[i].className = 'bi bi-plus-circle text-warning fs-4';
            }
        });

        if (content.style.display === 'block') {
            content.style.display = 'none';
            icon.className = 'bi bi-plus-circle text-warning fs-4';
        } else {
            content.style.display = 'block';
            icon.className = 'bi bi-dash-circle text-warning fs-4';
        }
    }
</script>

<?php include 'includes/footer.php'; ?>

