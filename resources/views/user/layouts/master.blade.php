<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    <style>
        /* Design Tokens & Theme Variables */
        :root {
            --primary: #1b4d3e;      /* Deep Forest Green */
            --secondary: #8a9a86;    /* Sage Accent */
            --accent: #d97706;       /* Warm Earth Gold */
            --background: #fdfbf7;   /* Off-white warm background */
            --surface: #ffffff;
            --text-main: #2d3748;
            --text-muted: #718096;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--text-main);
            line-height: 1.6;
        }

        /* Navigation Bar */
        nav {
            background-color: var(--primary);
            color: white;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        nav .logo {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        nav .logo span {
            color: var(--accent);
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        nav ul li a {
            color: #f7fafc;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: var(--accent);
        }

        /* Hero Banner Section */
        .hero {
            background: linear-gradient(rgba(27, 77, 62, 0.85), rgba(27, 77, 62, 0.95)), url('https://images.unsplash.com/photo-1516467508483-a7212febe31a?auto=format&fit=crop&q=80&w=1200') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 30px;
            color: #e2e8f0;
        }

        .search-bar {
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        .search-bar button {
            background-color: var(--accent);
            color: white;
            border: none;
            padding: 0 25px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .search-bar button:hover {
            background-color: #b45309;
        }

        /* Main Grid Wrapper */
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .section-title h2 {
            font-size: 32px;
            color: var(--primary);
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: var(--accent);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* Knowledge Library Grid */
        .knowledge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .hub-card {
            background: var(--surface);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .hub-card:hover {
            transform: translateY(-5px);
        }

        .hub-card .card-img {
            height: 200px;
            background-color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
        }

        .hub-card .card-content {
            padding: 25px;
        }

        .hub-card h3 {
            margin-bottom: 12px;
            color: var(--primary);
        }

        .hub-card p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .hub-card ul {
            list-style-type: none;
            margin-bottom: 20px;
        }

        .hub-card ul li {
            margin-bottom: 8px;
            font-size: 15px;
            display: flex;
            align-items: center;
        }

        .hub-card ul li::before {
            content: "✓";
            color: var(--accent);
            font-weight: bold;
            margin-right: 10px;
        }

        .btn-read {
            display: inline-block;
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
            border-bottom: 2px solid var(--primary);
            transition: 0.2s;
        }

        .btn-read:hover {
            color: var(--accent);
            border-color: var(--accent);
        }

        /* Feature Section: Disease Matrix Table */
        .diagnostic-matrix {
            background: var(--surface);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 60px;
        }

        .diagnostic-matrix table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .diagnostic-matrix th, .diagnostic-matrix td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .diagnostic-matrix th {
            background-color: var(--primary);
            color: white;
        }

        .badge {
            background: #fed7d7;
            color: #9b2c2c;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge.preventative {
            background: #c6f6d5;
            color: #22543d;
        }

        /* Share Your Knowledge Form Section */
        .share-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background-color: #f0f4f1;
            padding: 40px;
            border-radius: 10px;
        }

        .share-info h3 {
            color: var(--primary);
            font-size: 24px;
            margin-bottom: 15px;
        }

        .share-form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e0;
            border-radius: 5px;
            font-size: 15px;
        }

        .share-form button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            transition: background 0.3s;
        }

        .share-form button:hover {
            background-color: #123329;
        }

        /* Footer */
        footer {
            background-color: var(--primary);
            color: #e2e8f0;
            text-align: center;
            padding: 30px 20px;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">Bliss<span>Farm</span></div>
        <ul>
            <li><a href="#hub">Knowledge Hub</a></li>
            <li><a href="#diseases">Disease Quick Guide</a></li>
            <li><a href="#share">Share Research</a></li>
        </ul>
    </nav>

    @yield('content')
</body>
</html>
