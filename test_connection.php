<?php
/**
 * Database Connection Test Script
 * Run this to verify database connectivity
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 800px;
            width: 100%;
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
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px;
        }
        .test-item {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            background: #f8f9fa;
            border-left: 5px solid #ddd;
        }
        .test-item.success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        .test-item.error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        .icon {
            font-size: 2rem;
            margin-right: 20px;
            min-width: 40px;
            text-align: center;
        }
        .success .icon { color: #28a745; }
        .error .icon { color: #dc3545; }
        .test-content {
            flex: 1;
        }
        .test-content h3 {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }
        .test-content p {
            color: #666;
            font-size: 0.95rem;
            margin: 5px 0;
        }
        .code {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
            font-size: 0.9rem;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px 5px;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            margin-top: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Database Connection Test</h1>
            <p>HexaTP System Diagnostics</p>
        </div>

        <div class="content">
            <?php
            $tests = [];
            $errors = 0;
            $success = 0;

            // Test 1: Check if MySQLi extension is loaded
            if (extension_loaded('mysqli')) {
                $tests[] = [
                    'status' => 'success',
                    'title' => 'MySQLi Extension',
                    'message' => 'MySQLi extension is loaded and available'
                ];
                $success++;
            } else {
                $tests[] = [
                    'status' => 'error',
                    'title' => 'MySQLi Extension',
                    'message' => 'MySQLi extension is NOT loaded. Enable it in php.ini'
                ];
                $errors++;
            }

            // Test 2: Try to connect to MySQL server
            $dbHost = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'hexatp_db';

            $conn = @new mysqli($dbHost, $dbUser, $dbPass);
            
            if ($conn->connect_error) {
                $tests[] = [
                    'status' => 'error',
                    'title' => 'MySQL Server Connection',
                    'message' => 'Cannot connect to MySQL server',
                    'details' => 'Error: ' . $conn->connect_error
                ];
                $errors++;
            } else {
                $tests[] = [
                    'status' => 'success',
                    'title' => 'MySQL Server Connection',
                    'message' => 'Successfully connected to MySQL server'
                ];
                $success++;

                // Test 3: Check if database exists
                $dbExists = $conn->select_db($dbName);
                
                if ($dbExists) {
                    $tests[] = [
                        'status' => 'success',
                        'title' => 'Database Exists',
                        'message' => "Database '$dbName' exists and is accessible"
                    ];
                    $success++;

                    // Test 4: Check if tables exist
                    $tables = ['consultations', 'inquiries'];
                    $existingTables = [];
                    $missingTables = [];
                    
                    foreach ($tables as $table) {
                        $result = $conn->query("SHOW TABLES LIKE '$table'");
                        if ($result && $result->num_rows > 0) {
                            $existingTables[] = $table;
                        } else {
                            $missingTables[] = $table;
                        }
                    }

                    if (empty($missingTables)) {
                        $tests[] = [
                            'status' => 'success',
                            'title' => 'Database Tables',
                            'message' => 'All required tables exist',
                            'details' => 'Tables: ' . implode(', ', $existingTables)
                        ];
                        $success++;
                    } else {
                        $tests[] = [
                            'status' => 'error',
                            'title' => 'Database Tables',
                            'message' => 'Some tables are missing',
                            'details' => 'Missing: ' . implode(', ', $missingTables)
                        ];
                        $errors++;
                    }

                    // Test 5: Test INSERT permission
                    $testQuery = "CREATE TABLE IF NOT EXISTS test_connection (id INT)";
                    if ($conn->query($testQuery)) {
                        $conn->query("DROP TABLE IF EXISTS test_connection");
                        $tests[] = [
                            'status' => 'success',
                            'title' => 'Database Permissions',
                            'message' => 'Database has proper read/write permissions'
                        ];
                        $success++;
                    } else {
                        $tests[] = [
                            'status' => 'error',
                            'title' => 'Database Permissions',
                            'message' => 'Database permissions issue',
                            'details' => $conn->error
                        ];
                        $errors++;
                    }

                } else {
                    $tests[] = [
                        'status' => 'error',
                        'title' => 'Database Exists',
                        'message' => "Database '$dbName' does NOT exist",
                        'details' => 'You need to create the database first'
                    ];
                    $errors++;
                }

                $conn->close();
            }

            // Test 6: Check db_config.php file
            if (file_exists('db_config.php')) {
                $tests[] = [
                    'status' => 'success',
                    'title' => 'Configuration File',
                    'message' => 'db_config.php file exists'
                ];
                $success++;
            } else {
                $tests[] = [
                    'status' => 'error',
                    'title' => 'Configuration File',
                    'message' => 'db_config.php file is missing'
                ];
                $errors++;
            }

            // Display all tests
            foreach ($tests as $test) {
                $icon = $test['status'] === 'success' ? '✓' : '✗';
                echo "<div class='test-item {$test['status']}'>";
                echo "<div class='icon'>$icon</div>";
                echo "<div class='test-content'>";
                echo "<h3>{$test['title']}</h3>";
                echo "<p>{$test['message']}</p>";
                if (isset($test['details'])) {
                    echo "<p><small>{$test['details']}</small></p>";
                }
                echo "</div>";
                echo "</div>";
            }
            ?>

            <div class="summary">
                <h2>Test Results</h2>
                <p style="font-size: 1.2rem; margin: 20px 0;">
                    ✓ <?php echo $success; ?> Passed &nbsp;|&nbsp;
                    ✗ <?php echo $errors; ?> Failed
                </p>

                <?php if ($errors == 0): ?>
                    <p style="font-size: 1.3rem; margin: 20px 0;">
                        🎉 All tests passed! Database is connected!
                    </p>
                    <a href="index.html" class="btn">Go to Homepage</a>
                    <a href="contact.html" class="btn">Test Contact Form</a>
                <?php else: ?>
                    <p style="font-size: 1.1rem; margin: 20px 0;">
                        ⚠️ Please fix the errors above
                    </p>
                    <?php if ($errors > 0 && strpos(json_encode($tests), 'does NOT exist') !== false): ?>
                        <a href="create_database.php" class="btn">Create Database</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if ($errors > 0): ?>
            <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-left: 5px solid #ffc107; border-radius: 5px;">
                <h4 style="color: #856404; margin-bottom: 10px;">🔧 How to Fix</h4>
                <ol style="margin-left: 20px; line-height: 1.8; color: #856404;">
                    <li>Make sure XAMPP MySQL service is running</li>
                    <li>Create database 'hexatp_db' if it doesn't exist</li>
                    <li>Run the SQL script to create tables</li>
                    <li>Check database credentials in db_config.php</li>
                </ol>
            </div>
            <?php endif; ?>

            <div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-left: 5px solid #2196F3; border-radius: 5px;">
                <h4 style="color: #2196F3; margin-bottom: 10px;">📋 Current Configuration</h4>
                <div class="code">
                    <strong>Host:</strong> <?php echo $dbHost; ?><br>
                    <strong>User:</strong> <?php echo $dbUser; ?><br>
                    <strong>Database:</strong> <?php echo $dbName; ?><br>
                    <strong>PHP Version:</strong> <?php echo phpversion(); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
