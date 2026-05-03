<?php
/**
 * Global Header for HexaTP
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'HexaTP | Premium Transfer Pricing Solutions'; ?></title>
    <meta name="description" content="<?php echo isset($meta_description) ? htmlspecialchars($meta_description) : 'HexaTP provides premium transfer pricing solutions and global tax advisory services.'; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #050a14;
            --accent: #f5c400;
            --accent-glow: rgba(245, 196, 0, 0.3);
            --card-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-slate: #94a3b8;
        }

        body {
            background-color: var(--bg-dark);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        header {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1200px;
            z-index: 1000;
            background: rgba(11, 29, 53, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 100px;
            padding: 12px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .logo-img {
            height: 50px !important;
            width: auto !important;
            display: block;
            object-fit: contain;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
            margin: 0;
            padding: 0;
        }

        nav a {
            text-decoration: none;
            color: #ccc;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        nav a:hover {
            color: var(--accent);
        }

        .btn-main {
            background: var(--accent);
            color: #000;
            padding: 10px 25px;
            border-radius: 100px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 20px var(--accent-glow);
            transition: 0.3s;
            display: inline-block;
        }

        .btn-main:hover {
            transform: translateY(-3px);
            background: #fff;
            color: #000;
        }

        /* Mobile Nav */
        .mobile-nav-toggle {
            display: none;
            position: absolute;
            right: 5%;
            top: 20px;
            background: none;
            border: none;
            color: #f5c400;
            font-size: 28px;
            cursor: pointer;
            z-index: 1001;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .mobile-nav-toggle { display: block; }
            header nav.d-none.d-md-block { display: none !important; }
        }
    </style>
</head>
<body>
    <header>
        <a href="index.html">
            <img src="logo_new1.png" alt="HexaTP Logo" class="logo-img" />
        </a>
        <nav class="d-none d-md-block">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="aboutus.html">About</a></li>
                <li><a href="solution.html">Solutions</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
        <a href="contact.html" class="btn-main d-none d-md-inline-block">Book Consultation</a>
        <button class="mobile-nav-toggle d-md-none" onclick="toggleMobileMenu()">
            <i class="bi bi-list"></i>
        </button>
    </header>
