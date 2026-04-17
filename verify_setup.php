<?php
/**
 * Setup Verification Script
 * Run this to verify your XAMPP + MySQL setup
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaTP - Setup Verification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .check-item {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            background: #f8f9fa;
            border-left: 5px solid #ddd;
            transition: all 0.3s;
        }

        .check-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .check-item.success {
            border-left-color: #28a745;
            background: #d4edda;
        }

        .check-item.error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }

        .check-item.warning {
            border-left-color: #ffc107;
            background: #fff3cd;
        }

        .icon {
            font-size: 2rem;
            margin-right: 20px;
            min-width: 40px;
            text-align: center;
        }

        .check-content {
            flex: 1;
        }

        .check-content h3 {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }

        .check-content p {
            color: #666;
            font-size: 0.95rem;
        }

        .success .icon { color: #28a745; }
        .error .icon { color: #dc3545; }
        .warning .icon { color: #ffc107; }

        .summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            margin-top: 30px;
            border-radius: 10px;
        }

        .summary h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .info-box {
            background: #e7f3ff;
            border-left: 5px solid #2196F3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .info-box h4 {
            color: #2196F3;
            margin-bottom: 10px;
        }

        .code {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Setup Verification</h1>
            <p>HexaTP XAMPP + MySQL Configuration Check</p>
        </div>

        <div class="content">
            <?php
            $checks = [];
            $errors = 0;
            $warnings = 0;
            $success = 0;

            // Check 1: PHP Version
            $phpVersion = phpversion();
            if (version_compare($phpVersion, '7.4.0', '>=')) {
                $checks[] = [
                    'status' => 'success',
                    'title' => 'PHP Version',
                    'message' => "PHP $phpVersion is installed and compatible"
                ];
                $success++;
            } else {
                $checks[] = [
                    'status' => 'warning',
                    'title' => 'PHP Version',
                    'message' => "PHP $phpVersion detected. Recommended: 7.4 or higher"
                ];
                $warnings++;
            }

            // Check 2: MySQL Extension
            if (extension_loaded('mysqli')) {
                $checks[] = [
                    'status' => 'success',
                    'title' => 'MySQL Extension',
                    'message' => 'MySQLi extension is loaded and ready'
                ];
                $success++;
            } else {
                $checks[] = [
                    'status' => 'error',
                    'title' => 'MySQL Extension',
                    'message' => 'MySQLi extension is not loaded. Enable it in php.ini'
                ];
                $errors++;
            }

            // Check 3: Database Connection
            $dbHost = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'hexatp_db';

            $conn = @new mysqli($dbHost, $dbUser, $dbPass);
            if ($conn->connect_error) {
                $checks[] = [
                    'status' => 'error',
                    'title' => 'MySQL Connection',
                    'message' => 'Cannot connect to MySQL: ' . $conn->connect_error
                ];
                $errors++;
            } else {
                $checks[] = [
                    'status' => 'success',
                    'title' => 'MySQL Connection',
                    'message' => 'Successfully connected to MySQL server'
                ];
                $success++;

                // Check 4: Database Exists
                $dbExists = $conn->select_db($dbName);
                if ($dbExists) {
                    $checks[] = [
                        'status' => 'success',
                        'title' => 'Database',
                        'message' => "Database '$dbName' exists and is accessible"
                    ];
                    $success++;

                    // Check 5: Tables Exist
                    $tables = ['consultations', 'inquiries'];
                    $missingTables = [];
                    
                    foreach ($tables as $table) {
                        $result = $conn->query("SHOW TABLES LIKE '$table'");
                        if ($result->num_rows == 0) {
                            $missingTables[] = $table;
                        }
                    }

                    if (empty($missingTables)) {
                        $checks[] = [
                            'status' => 'success',
                            'title' => 'Database Tables',
                            'message' => 'All required tables exist (consultations, inquiries)'
                        ];
                        $success++;
                    } else {
                        $checks[] = [
                            'status' => 'warning',
                            'title' => 'Database Tables',
                            'message' => 'Missing tables: ' . implode(', ', $missingTables) . '. Run setup_database.php'
                        ];
                        $warnings++;
                    }
                } else {
                    $checks[] = [
                        'status' => 'warning',
                        'title' => 'Database',
                        'message' => "Database '$dbName' does not exist. Run setup_database.php to create it"
                    ];
                    $warnings++;
                }

                $conn->close();
            }

            // Check 6: Required Files
            $requiredFiles = [
                'index.html' => 'Homepage',
                'contact.html' => 'Contact Page',
                'db_config.php' => 'Database Config',
                'save_inquiry.php' => 'Form Handler',
                'setup_database.php' => 'Database Setup',
                'admin_consultations.php' => 'Admin Panel'
            ];

            $missingFiles = [];
            foreach ($requiredFiles as $file => $description) {
                if (!file_exists($file)) {
                    $missingFiles[] = "$description ($file)";
                }
            }

            if (empty($missingFiles)) {
                $checks[] = [
                    'status' => 'success',
                    'title' => 'Required Files',
                    'message' => 'All required files are present'
                ];
                $success++;
            } else {
                $checks[] = [
                    'status' => 'error',
                    'title' => 'Required Files',
                    'message' => 'Missing files: ' . implode(', ', $missingFiles)
                ];
                $errors++;
            }

            // Check 7: MongoDB Removed
            if (!file_exists('node_modules')) {
                $checks[] = [
                    'status' => 'success',
                    'title' => 'MongoDB Cleanup',
                    'message' => 'MongoDB node_modules successfully removed'
                ];
                $success++;
            } else {
                $checks[] = [
                    'status' => 'warning',
                    'title' => 'MongoDB Cleanup',
                    'message' => 'node_modules folder still exists. Consider removing if not needed'
                ];
                $warnings++;
            }

            // Display all checks
            foreach ($checks as $check) {
                $icon = $check['status'] === 'success' ? '✓' : ($check['status'] === 'error' ? '✗' : '⚠');
                echo "<div class='check-item {$check['status']}'>";
                echo "<div class='icon'>$icon</div>";
                echo "<div class='check-content'>";
                echo "<h3>{$check['title']}</h3>";
                echo "<p>{$check['message']}</p>";
                echo "</div>";
                echo "</div>";
            }
            ?>

            <div class="summary">
                <h2>Verification Summary</h2>
                <p style="font-size: 1.2rem; margin: 20px 0;">
                    ✓ <?php echo $success; ?> Passed &nbsp;|&nbsp;
                    ⚠ <?php echo $warnings; ?> Warnings &nbsp;|&nbsp;
                    ✗ <?php echo $errors; ?> Errors
                </p>

                <?php if ($errors == 0 && $warnings == 0): ?>
                    <p style="font-size: 1.3rem; margin: 20px 0;">
                        🎉 Perfect! Your setup is complete and ready to use!
                    </p>
                <?php elseif ($errors == 0): ?>
                    <p style="font-size: 1.1rem; margin: 20px 0;">
                        ✅ Setup is functional with minor warnings
                    </p>
                <?php else: ?>
                    <p style="font-size: 1.1rem; margin: 20px 0;">
                        ⚠️ Please fix the errors above before proceeding
                    </p>
                <?php endif; ?>

                <div style="margin-top: 30px;">
                    <a href="index.html" class="btn">View Homepage</a>
                    <a href="contact.html" class="btn">Test Contact Form</a>
                    <a href="admin_consultations.php" class="btn">Admin Panel</a>
                    <a href="setup_database.php" class="btn">Setup Database</a>
                </div>
            </div>

            <div class="info-box">
                <h4>📍 Your Setup Information</h4>
                <div class="code">
                    <strong>Local URL:</strong> http://localhost/hexatp-main/<br>
                    <strong>Database:</strong> hexatp_db<br>
                    <strong>PHP Version:</strong> <?php echo $phpVersion; ?><br>
                    <strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?><br>
                    <strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?>
                </div>
            </div>

            <div class="info-box">
                <h4>🚀 Next Steps</h4>
                <ol style="margin-left: 20px; line-height: 1.8;">
                    <li>If database doesn't exist, click "Setup Database" button above</li>
                    <li>Test the contact form at <a href="contact.html">contact.html</a></li>
                    <li>View submissions in <a href="admin_consultations.php">admin panel</a></li>
                    <li>Connect to GitHub: <code>git remote add origin https://github.com/sakshidhawale5004/hexa-final.git</code></li>
                    <li>Read <a href="XAMPP_SETUP_GUIDE.md">XAMPP_SETUP_GUIDE.md</a> for detailed instructions</li>
                </ol>
            </div>
        </div>
    </div>
</body>
</html>
