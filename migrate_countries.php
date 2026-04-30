<?php
/**
 * Country Content Migration Script
 * 
 * This script migrates existing country HTML files into the CMS database.
 * It extracts hero sections, overview content, regulatory frameworks, and documentation cards.
 * 
 * Usage: Run this file once from your browser: hexatp.com/migrate_countries.php
 * 
 * Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 6.6, 6.7, 6.8
 */

// Set execution time limit (migration may take a while)
set_time_limit(300); // 5 minutes

// Load dependencies
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/models/Country.php';
require_once __DIR__ . '/repositories/CountryRepository.php';

// Initialize
$conn = getDBConnection();
$countryRepo = new CountryRepository($conn);

// Migration results
$results = [
    'success' => [],
    'errors' => [],
    'skipped' => []
];

// Country mapping: filename => [country_name, country_code, flag_url]
$countries_to_migrate = [
    // Gulf Region
    'unitedarab.html' => [
        'name' => 'United Arab Emirates',
        'code' => 'AE',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/c/cb/Flag_of_the_United_Arab_Emirates.svg'
    ],
    'Saudiarabia.html' => [
        'name' => 'Saudi Arabia',
        'code' => 'SA',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/0/0d/Flag_of_Saudi_Arabia.svg'
    ],
    'Qatar.html' => [
        'name' => 'Qatar',
        'code' => 'QA',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/6/65/Flag_of_Qatar.svg'
    ],
    'oman.html' => [
        'name' => 'Oman',
        'code' => 'OM',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/d/dd/Flag_of_Oman.svg'
    ],
    'bahrain.html' => [
        'name' => 'Bahrain',
        'code' => 'BH',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/2/2c/Flag_of_Bahrain.svg'
    ],
    'egypt.html' => [
        'name' => 'Egypt',
        'code' => 'EG',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/f/fe/Flag_of_Egypt.svg'
    ],
    
    // Asia
    'India.html' => [
        'name' => 'India',
        'code' => 'IN',
        'flag' => 'https://upload.wikimedia.org/wikipedia/en/4/41/Flag_of_India.svg'
    ],
    'bangladesh.html' => [
        'name' => 'Bangladesh',
        'code' => 'BD',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/f/f9/Flag_of_Bangladesh.svg'
    ],
    
    // South East Asia
    'singapore.html' => [
        'name' => 'Singapore',
        'code' => 'SG',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Singapore.svg'
    ],
    'thailand.html' => [
        'name' => 'Thailand',
        'code' => 'TH',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Flag_of_Thailand.svg'
    ],
    'malaysia.html' => [
        'name' => 'Malaysia',
        'code' => 'MY',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/6/66/Flag_of_Malaysia.svg'
    ],
    'australia.html' => [
        'name' => 'Australia',
        'code' => 'AU',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/8/88/Flag_of_Australia_%28converted%29.svg'
    ],
    'indonesia.html' => [
        'name' => 'Indonesia',
        'code' => 'ID',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/9/9f/Flag_of_Indonesia.svg'
    ],
    'viethnam.html' => [
        'name' => 'Vietnam',
        'code' => 'VN',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Vietnam.svg'
    ],
    
    // Africa
    'botswana.html' => [
        'name' => 'Botswana',
        'code' => 'BW',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Flag_of_Botswana.svg'
    ],
    'ghana.html' => [
        'name' => 'Ghana',
        'code' => 'GH',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/1/19/Flag_of_Ghana.svg'
    ],
    'kenya.html' => [
        'name' => 'Kenya',
        'code' => 'KE',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/4/49/Flag_of_Kenya.svg'
    ],
    
    // Americas
    'canada.html' => [
        'name' => 'Canada',
        'code' => 'CA',
        'flag' => 'https://upload.wikimedia.org/wikipedia/commons/d/d9/Flag_of_Canada_%28Pantone%29.svg'
    ],
    'us.html' => [
        'name' => 'United States',
        'code' => 'US',
        'flag' => 'https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg'
    ]
];

/**
 * Extract hero section from HTML
 */
function extractHeroSection($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    
    $hero = [
        'title' => '',
        'description' => ''
    ];
    
    // Find hero section
    $heroSection = $xpath->query("//section[contains(@class, 'hero')]")->item(0);
    if ($heroSection) {
        // Extract title (h1)
        $h1 = $xpath->query(".//h1", $heroSection)->item(0);
        if ($h1) {
            $hero['title'] = trim(strip_tags($dom->saveHTML($h1)));
            $hero['title'] = preg_replace('/\s+/', ' ', $hero['title']); // Normalize whitespace
        }
        
        // Extract description (first p tag)
        $p = $xpath->query(".//p", $heroSection)->item(0);
        if ($p) {
            $hero['description'] = trim($dom->saveHTML($p));
            $hero['description'] = str_replace(['<p>', '</p>'], '', $hero['description']);
        }
    }
    
    return $hero;
}

/**
 * Extract overview section from HTML
 */
function extractOverview($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    
    $overview = [
        'left' => '',
        'right' => ''
    ];
    
    // Find section with "Landscape" or "Overview" in title
    $sections = $xpath->query("//section[.//h2[contains(text(), 'Landscape') or contains(text(), 'Overview')]]");
    if ($sections->length > 0) {
        $section = $sections->item(0);
        
        // Find all paragraphs in columns
        $columns = $xpath->query(".//div[contains(@class, 'col-lg-6')]", $section);
        
        if ($columns->length >= 1) {
            $leftCol = $columns->item(0);
            $leftP = $xpath->query(".//p", $leftCol);
            if ($leftP->length > 0) {
                $overview['left'] = trim($dom->saveHTML($leftP->item(0)));
            }
        }
        
        if ($columns->length >= 2) {
            $rightCol = $columns->item(1);
            $rightP = $xpath->query(".//p", $rightCol);
            if ($rightP->length > 0) {
                $overview['right'] = trim($dom->saveHTML($rightP->item(0)));
            }
        }
    }
    
    return $overview;
}

/**
 * Extract regulatory frameworks from HTML
 */
function extractRegulatoryFrameworks($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    
    $frameworks = [];
    
    // Find section with "Regulatory" or "Framework" in title
    $sections = $xpath->query("//section[.//h2[contains(text(), 'Regulatory') or contains(text(), 'Framework')]]");
    if ($sections->length > 0) {
        $section = $sections->item(0);
        
        // Find all reg-box divs
        $boxes = $xpath->query(".//div[contains(@class, 'reg-box')]", $section);
        
        $order = 1;
        foreach ($boxes as $box) {
            $title = '';
            $description = '';
            
            // Extract title (h5)
            $h5 = $xpath->query(".//h5", $box)->item(0);
            if ($h5) {
                $title = trim(strip_tags($dom->saveHTML($h5)));
            }
            
            // Extract description (p)
            $p = $xpath->query(".//p", $box)->item(0);
            if ($p) {
                $description = trim($dom->saveHTML($p));
            }
            
            if ($title && $description) {
                $frameworks[] = [
                    'title' => $title,
                    'description' => $description,
                    'display_order' => $order++
                ];
            }
            
            // Limit to 3 frameworks
            if (count($frameworks) >= 3) {
                break;
            }
        }
    }
    
    // Ensure we have exactly 3 frameworks (pad with empty if needed)
    while (count($frameworks) < 3) {
        $frameworks[] = [
            'title' => 'Framework ' . (count($frameworks) + 1),
            'description' => '<p>Information coming soon.</p>',
            'display_order' => count($frameworks) + 1
        ];
    }
    
    return array_slice($frameworks, 0, 3); // Ensure exactly 3
}

/**
 * Extract documentation cards from HTML
 */
function extractDocumentationCards($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    
    $cards = [];
    
    // Find section with "Documentation" or "Pillars" in title
    $sections = $xpath->query("//section[.//h2[contains(text(), 'Documentation') or contains(text(), 'Pillars')]]");
    if ($sections->length > 0) {
        $section = $sections->item(0);
        
        // Find all glass-card divs
        $glassCards = $xpath->query(".//div[contains(@class, 'glass-card')]", $section);
        
        $order = 1;
        foreach ($glassCards as $card) {
            $title = '';
            $shortDesc = '';
            $detailedContent = '';
            
            // Extract title from arrow span
            $arrow = $xpath->query(".//span[contains(@class, 'arrow')]", $card)->item(0);
            if ($arrow) {
                $titleText = trim(strip_tags($dom->saveHTML($arrow)));
                // Remove arrow character
                $title = trim(str_replace(['▶', '►', '▼'], '', $titleText));
            }
            
            // Extract short description (first p after arrow)
            $firstP = $xpath->query(".//p[not(ancestor::div[contains(@class, 'content')])]", $card)->item(0);
            if ($firstP) {
                $shortDesc = trim($dom->saveHTML($firstP));
            }
            
            // Extract detailed content from content div
            $contentDiv = $xpath->query(".//div[contains(@class, 'content')]", $card)->item(0);
            if ($contentDiv) {
                $contentPs = $xpath->query(".//p", $contentDiv);
                $detailedParts = [];
                foreach ($contentPs as $p) {
                    $detailedParts[] = trim($dom->saveHTML($p));
                }
                $detailedContent = implode("\n", $detailedParts);
            }
            
            if ($title) {
                $cards[] = [
                    'title' => $title,
                    'short_description' => $shortDesc ?: '<p>Click to expand for details.</p>',
                    'detailed_content' => $detailedContent ?: '<p>Detailed information coming soon.</p>',
                    'display_order' => $order++
                ];
            }
        }
    }
    
    return $cards;
}

/**
 * Migrate a single country
 */
function migrateCountry($filename, $countryData, $countryRepo) {
    global $results;
    
    $filepath = __DIR__ . '/' . $filename;
    
    // Check if file exists
    if (!file_exists($filepath)) {
        $results['errors'][] = "$filename: File not found";
        return false;
    }
    
    // Read HTML content
    $html = file_get_contents($filepath);
    if (!$html) {
        $results['errors'][] = "$filename: Could not read file";
        return false;
    }
    
    try {
        // Extract content
        $hero = extractHeroSection($html);
        $overview = extractOverview($html);
        $frameworks = extractRegulatoryFrameworks($html);
        $cards = extractDocumentationCards($html);
        
        // Create Country object
        $country = new Country();
        $country->country_name = $countryData['name'];
        $country->country_code = $countryData['code'];
        $country->flag_url = $countryData['flag'];
        $country->hero_title = $hero['title'] ?: "Transfer Pricing " . $countryData['name'];
        $country->hero_description = $hero['description'] ?: "Navigate " . $countryData['name'] . "'s transfer pricing requirements.";
        $country->meta_title = $countryData['name'] . " Transfer Pricing | HexaTP";
        $country->meta_description = "Complete guide to " . $countryData['name'] . " transfer pricing regulations and compliance.";
        $country->status = 'published'; // Set as published
        
        // Save country to database
        $country_id = $countryRepo->create($country);
        
        if (!$country_id) {
            $results['errors'][] = "$filename: Failed to create country record";
            return false;
        }
        
        // Save overview
        if ($overview['left'] || $overview['right']) {
            $conn = $countryRepo->getConnection();
            $stmt = $conn->prepare("
                INSERT INTO country_overview (country_id, overview_text_left, overview_text_right)
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param('iss', $country_id, $overview['left'], $overview['right']);
            $stmt->execute();
            $stmt->close();
        }
        
        // Save regulatory frameworks
        foreach ($frameworks as $framework) {
            $conn = $countryRepo->getConnection();
            $stmt = $conn->prepare("
                INSERT INTO regulatory_frameworks (country_id, title, description, display_order)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param('issi', 
                $country_id, 
                $framework['title'], 
                $framework['description'], 
                $framework['display_order']
            );
            $stmt->execute();
            $stmt->close();
        }
        
        // Save documentation cards
        foreach ($cards as $card) {
            $conn = $countryRepo->getConnection();
            $stmt = $conn->prepare("
                INSERT INTO documentation_cards (country_id, title, short_description, detailed_content, display_order)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->bind_param('isssi', 
                $country_id, 
                $card['title'], 
                $card['short_description'], 
                $card['detailed_content'], 
                $card['display_order']
            );
            $stmt->execute();
            $stmt->close();
        }
        
        $results['success'][] = "$filename: Successfully migrated {$countryData['name']} (ID: $country_id)";
        return true;
        
    } catch (Exception $e) {
        $results['errors'][] = "$filename: " . $e->getMessage();
        return false;
    }
}

// Start migration
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Country Migration | HexaTP CMS</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        body { background: #050a14; color: #fff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px 20px; }
        .container { max-width: 900px; }
        .card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px; margin-bottom: 20px; }
        .success { color: #4caf50; }
        .error { color: #ff6b6b; }
        .skipped { color: #ff9800; }
        h1 { color: #f5c400; margin-bottom: 30px; }
        .progress { height: 30px; background: rgba(255,255,255,0.1); }
        .progress-bar { background: #f5c400; }
        .btn-primary { background: #f5c400; color: #000; border: none; font-weight: 600; }
        .btn-primary:hover { background: #ffd700; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🌍 Country Content Migration</h1>
        <div class='card'>
            <h3>Migration Progress</h3>
            <div class='progress mb-3'>
                <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: 0%' id='progressBar'>0%</div>
            </div>
            <div id='status'>Starting migration...</div>
        </div>
        <div class='card' id='results' style='display:none;'>
            <h3>Migration Results</h3>
            <div id='resultsContent'></div>
        </div>
    </div>
    <script>
        let processed = 0;
        const total = " . count($countries_to_migrate) . ";
        
        function updateProgress() {
            processed++;
            const percent = Math.round((processed / total) * 100);
            document.getElementById('progressBar').style.width = percent + '%';
            document.getElementById('progressBar').textContent = percent + '%';
        }
    </script>
";

echo "<script>document.getElementById('status').innerHTML = 'Migrating countries...';</script>";
flush();

// Migrate each country
foreach ($countries_to_migrate as $filename => $countryData) {
    echo "<script>document.getElementById('status').innerHTML += '<br>Processing {$countryData['name']}...';</script>";
    flush();
    
    migrateCountry($filename, $countryData, $countryRepo);
    
    echo "<script>updateProgress();</script>";
    flush();
}

// Display results
echo "<script>
    document.getElementById('results').style.display = 'block';
    let html = '';
    
    // Success
    html += '<h4 class=\"success\">✅ Successfully Migrated (" . count($results['success']) . ")</h4>';
    html += '<ul>';
";

foreach ($results['success'] as $success) {
    echo "html += '<li class=\"success\">" . addslashes($success) . "</li>';";
}

echo "html += '</ul>';";

// Errors
if (!empty($results['errors'])) {
    echo "html += '<h4 class=\"error\">❌ Errors (" . count($results['errors']) . ")</h4>';";
    echo "html += '<ul>';";
    foreach ($results['errors'] as $error) {
        echo "html += '<li class=\"error\">" . addslashes($error) . "</li>';";
    }
    echo "html += '</ul>';";
}

echo "
    html += '<hr>';
    html += '<h4>📊 Summary</h4>';
    html += '<p>Total countries processed: <strong>" . count($countries_to_migrate) . "</strong></p>';
    html += '<p>Successfully migrated: <strong class=\"success\">" . count($results['success']) . "</strong></p>';
    html += '<p>Errors: <strong class=\"error\">" . count($results['errors']) . "</strong></p>';
    html += '<hr>';
    html += '<a href=\"admin/countries_list.php\" class=\"btn btn-primary mt-3\">View Countries in CMS</a>';
    html += '<a href=\"admin/dashboard.php\" class=\"btn btn-secondary mt-3 ms-2\">Go to Dashboard</a>';
    
    document.getElementById('resultsContent').innerHTML = html;
    document.getElementById('status').innerHTML = '<strong>Migration Complete!</strong>';
</script>
";

echo "</body></html>";

// Close connection
$conn->close();
?>
