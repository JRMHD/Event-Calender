<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Calendar - Modern Event Management</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts - Sora -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4285F4;
            --primary-dark: #1967D3;
            --secondary: #34A853;
            --accent: #FBBC04;
            --success: #34A853;
            --warning: #FBBC04;
            --error: #EA4335;

            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;

            --border: #e2e8f0;
            --border-light: #f1f5f9;

            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);

            --gradient-1: linear-gradient(135deg, #4285F4 0%, #1967D3 100%);
            --gradient-2: linear-gradient(135deg, #EA4335 0%, #C5221F 100%);
            --gradient-3: linear-gradient(135deg, #34A853 0%, #137333 100%);
            --gradient-4: linear-gradient(135deg, #FBBC04 0%, #F9AB00 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', system-ui, -apple-system, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Modern Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow);
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-family: 'Sora', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none;
        }

        .logo-img {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            font-family: inherit;
            position: relative;
            overflow: hidden;
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Modern Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 6rem 2rem 2rem;
            background:
                radial-gradient(ellipse at top, rgba(66, 133, 244, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(52, 168, 83, 0.1) 0%, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%236366f1' fill-opacity='0.02'%3E%3Cpath d='m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            opacity: 0.5;
        }

        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            animation: slideInLeft 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-text h1 {
            font-family: 'Sora', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text .subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-weight: 400;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .btn-hero {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 16px;
        }

        .hero-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            background: rgba(255, 255, 255, 0.95);
        }

        .feature-icon-small {
            width: 40px;
            height: 40px;
            background: var(--gradient-1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .feature-item:nth-child(2) .feature-icon-small {
            background: var(--gradient-3);
        }

        .feature-item:nth-child(3) .feature-icon-small {
            background: var(--gradient-4);
        }

        .feature-item span {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        /* Modern Hero Visual */
        .hero-visual {
            position: relative;
            animation: slideInRight 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .calendar-showcase {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            z-index: 1;
        }

        .main-calendar-card {
            background: var(--bg-primary);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border-light);
            position: relative;
            z-index: 3;
            backdrop-filter: blur(12px);
        }

        .calendar-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .calendar-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .calendar-nav {
            display: flex;
            gap: 0.5rem;
        }

        .nav-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--bg-secondary);
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: var(--text-secondary);
        }

        .nav-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.75rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .calendar-day.header {
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.8rem;
            cursor: default;
        }

        .calendar-day.today {
            background: var(--primary);
            color: white;
            font-weight: 600;
        }

        .calendar-day.event {
            background: var(--gradient-1);
            color: white;
            font-weight: 600;
        }

        .calendar-day.event-secondary {
            background: var(--gradient-3);
            color: white;
            font-weight: 600;
        }

        .calendar-day.event-accent {
            background: var(--gradient-4);
            color: white;
            font-weight: 600;
        }

        .calendar-day:not(.header):hover {
            background: var(--bg-secondary);
            transform: scale(1.1);
        }

        .calendar-day.today:hover,
        .calendar-day.event:hover,
        .calendar-day.event-secondary:hover,
        .calendar-day.event-accent:hover {
            transform: scale(1.1);
        }

        /* Floating Elements */
        .floating-card {
            position: absolute;
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-light);
            backdrop-filter: blur(12px);
            z-index: 4;
            animation: float 6s ease-in-out infinite;
        }

        /* Hero background elements */
        .hero::before {
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .floating-card-1 {
            top: 10%;
            right: -10%;
            animation-delay: 0s;
        }

        .floating-card-2 {
            bottom: 20%;
            left: -15%;
            animation-delay: 2s;
        }

        .floating-card-3 {
            top: 60%;
            right: 10%;
            animation-delay: 4s;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .card-icon-1 { background: var(--gradient-1); }
        .card-icon-2 { background: var(--gradient-2); }
        .card-icon-3 { background: var(--gradient-3); }

        .card-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .card-subtitle {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* Features Section */
        .features {
            padding: 8rem 2rem;
            background: var(--bg-secondary);
            position: relative;
        }

        .features-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-badge {
            display: inline-block;
            background: var(--bg-primary);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border: 1px solid var(--border);
        }

        .section-title {
            font-family: 'Sora', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--bg-primary);
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-light);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-1);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .feature-card:nth-child(2)::before { background: var(--gradient-2); }
        .feature-card:nth-child(3)::before { background: var(--gradient-3); }
        .feature-card:nth-child(4)::before { background: var(--gradient-4); }
        .feature-card:nth-child(5)::before { background: var(--gradient-1); }
        .feature-card:nth-child(6)::before { background: var(--gradient-2); }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            background: var(--gradient-1);
        }

        .feature-card:nth-child(2) .feature-icon { background: var(--gradient-2); }
        .feature-card:nth-child(3) .feature-icon { background: var(--gradient-3); }
        .feature-card:nth-child(4) .feature-icon { background: var(--gradient-4); }
        .feature-card:nth-child(5) .feature-icon { background: var(--gradient-1); }
        .feature-card:nth-child(6) .feature-icon { background: var(--gradient-2); }

        .feature-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .feature-description {
            color: var(--text-secondary);
            line-height: 1.6;
            font-size: 1rem;
        }

        /* CTA Section */
        .cta {
            padding: 8rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='m20 20 20 20-20-20z'/%3E%3C/g%3E%3C/svg%3E") repeat;
            animation: float 20s linear infinite;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-family: 'Sora', sans-serif;
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .btn-cta {
            background: var(--bg-primary);
            color: var(--primary);
            padding: 1.25rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
        }

        .btn-cta:hover {
            background: var(--bg-secondary);
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        /* Footer */
        .footer {
            padding: 4rem 2rem 2rem;
            background: var(--text-primary);
            color: var(--bg-primary);
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-family: 'Sora', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--bg-primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--bg-primary);
        }

        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(1deg); }
            50% { transform: translateY(-10px) rotate(-1deg); }
            75% { transform: translateY(-15px) rotate(0.5deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .fade-in-up.delay-1 { animation-delay: 0.2s; opacity: 0; }
        .fade-in-up.delay-2 { animation-delay: 0.4s; opacity: 0; }
        .fade-in-up.delay-3 { animation-delay: 0.6s; opacity: 0; }

        /* Mobile menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .mobile-menu-btn:hover {
            background: var(--bg-secondary);
            color: var(--primary);
        }

        .mobile-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--bg-primary);
            border-top: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
        }

        .mobile-nav.active {
            display: block;
        }

        .mobile-nav-links {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .mobile-nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .mobile-nav-link:hover {
            background: var(--bg-secondary);
            color: var(--primary);
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }

            .hero-features {
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .logo {
                font-size: 1rem;
                gap: 0.75rem;
            }

            .logo-img {
                width: 45px;
                height: 45px;
            }

            .btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .hero-text h1 {
                font-size: 1.6rem;
                margin-bottom: 1rem;
                line-height: 1.2;
            }

            .hero-text .subtitle {
                font-size: 1.1rem;
                margin-bottom: 1.5rem;
            }

            .hero-features {
                grid-template-columns: 1fr;
                gap: 1rem;
                justify-items: center;
            }

            .nav {
                padding: 1rem;
            }

            .hero {
                padding: 8rem 1rem 1rem;
                min-height: 90vh;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-hero {
                width: 100%;
                max-width: 280px;
            }

            .features,
            .cta {
                padding: 4rem 1rem;
            }

            .floating-card {
                display: none;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        /* Modern SVG Icons */
        .icon-calendar {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'/%3E%3C/svg%3E");
        }

        .icon-users {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'/%3E%3C/svg%3E");
        }

        .icon-lightning {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13 10V3L4 14h7v7l9-11h-7z'/%3E%3C/svg%3E");
        }

        .icon-bell {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'/%3E%3C/svg%3E");
        }

        .icon-mobile {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z'/%3E%3C/svg%3E");
        }

        .icon-sparkles {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body>
    <!-- Modern Header -->
    <header class="header" id="header">
        <nav class="nav">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Unity Calendar" class="logo-img">
                Unity Calendar
            </a>

            <div class="nav-links">
                <a href="#features" class="nav-link">Features</a>
                <a href="#about" class="nav-link">About</a>
            </div>

            <div class="auth-buttons">
                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        @endif
                    @endauth
                @endif
                <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>
            </div>

            <!-- Mobile Navigation -->
            <div class="mobile-nav" id="mobileNav">
                <div class="mobile-nav-links">
                    <a href="#features" class="mobile-nav-link">Features</a>
                    <a href="#about" class="mobile-nav-link">About</a>
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">Admin Dashboard</a>
                            @else
                                <a href="{{ route('dashboard') }}" class="mobile-nav-link">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="mobile-nav-link">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="mobile-nav-link">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Modern Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Where Teams Come Together</h1>
                <p class="subtitle">Streamline your events, boost collaboration, and never miss a moment. Unity Calendar brings your team's schedule into perfect harmony with intelligent planning and seamless coordination.</p>

                <div class="hero-buttons">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary btn-hero">Start Free Trial</a>
                    @endif
                    <a href="#features" class="btn btn-ghost btn-hero">Explore Features</a>
                </div>

                <div class="hero-features">
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Smart Scheduling</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Team Collaboration</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon-small">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Lightning Fast</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="calendar-showcase">
                    <div class="main-calendar-card">
                        <div class="calendar-header">
                            <h3 class="calendar-title">September 2024</h3>
                            <div class="calendar-nav">
                                <button class="nav-btn">9</button>
                                <button class="nav-btn">:</button>
                            </div>
                        </div>

                        <div class="calendar-grid">
                            <div class="calendar-day header">Su</div>
                            <div class="calendar-day header">Mo</div>
                            <div class="calendar-day header">Tu</div>
                            <div class="calendar-day header">We</div>
                            <div class="calendar-day header">Th</div>
                            <div class="calendar-day header">Fr</div>
                            <div class="calendar-day header">Sa</div>
                            <div class="calendar-day">1</div>
                            <div class="calendar-day">2</div>
                            <div class="calendar-day event">3</div>
                            <div class="calendar-day">4</div>
                            <div class="calendar-day today">5</div>
                            <div class="calendar-day">6</div>
                            <div class="calendar-day">7</div>
                            <div class="calendar-day">8</div>
                            <div class="calendar-day">9</div>
                            <div class="calendar-day event-secondary">10</div>
                            <div class="calendar-day">11</div>
                            <div class="calendar-day">12</div>
                            <div class="calendar-day">13</div>
                            <div class="calendar-day">14</div>
                            <div class="calendar-day event-accent">15</div>
                            <div class="calendar-day">16</div>
                            <div class="calendar-day">17</div>
                            <div class="calendar-day">18</div>
                            <div class="calendar-day event">19</div>
                            <div class="calendar-day">20</div>
                            <div class="calendar-day">21</div>
                            <div class="calendar-day">22</div>
                            <div class="calendar-day">23</div>
                            <div class="calendar-day">24</div>
                            <div class="calendar-day">25</div>
                            <div class="calendar-day">26</div>
                            <div class="calendar-day">27</div>
                            <div class="calendar-day">28</div>
                            <div class="calendar-day">29</div>
                            <div class="calendar-day">30</div>
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="floating-card floating-card-1">
                        <div class="card-icon card-icon-1">=�</div>
                        <div class="card-title">Team Standup</div>
                        <div class="card-subtitle">9:00 AM - 9:30 AM</div>
                    </div>

                    <div class="floating-card floating-card-2">
                        <div class="card-icon card-icon-2">=�</div>
                        <div class="card-title">Product Launch</div>
                        <div class="card-subtitle">2:00 PM - 4:00 PM</div>
                    </div>

                    <div class="floating-card floating-card-3">
                        <div class="card-icon card-icon-3">=�</div>
                        <div class="card-title">Client Meeting</div>
                        <div class="card-subtitle">Tomorrow 10:00 AM</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <div class="section-header fade-in-up">
                <div class="section-badge">Features</div>
                <h2 class="section-title">Everything You Need to Succeed</h2>
                <p class="section-subtitle">Powerful tools designed to streamline your workflow and boost team productivity with cutting-edge calendar management.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card fade-in-up delay-1">
                    <div class="feature-icon icon-calendar"></div>
                    <h3 class="feature-title">Smart Scheduling</h3>
                    <p class="feature-description">AI-powered scheduling suggestions that automatically find the best meeting times based on team availability and preferences.</p>
                </div>

                <div class="feature-card fade-in-up delay-2">
                    <div class="feature-icon icon-users"></div>
                    <h3 class="feature-title">Team Collaboration</h3>
                    <p class="feature-description">Real-time collaboration tools that keep your entire team synchronized with shared calendars and instant updates.</p>
                </div>

                <div class="feature-card fade-in-up delay-3">
                    <div class="feature-icon icon-lightning"></div>
                    <h3 class="feature-title">Lightning Fast</h3>
                    <p class="feature-description">Create events in seconds with our intuitive interface and smart templates that adapt to your workflow patterns.</p>
                </div>

                <div class="feature-card fade-in-up delay-1">
                    <div class="feature-icon icon-bell"></div>
                    <h3 class="feature-title">Smart Notifications</h3>
                    <p class="feature-description">Intelligent reminders that learn from your behavior and send notifications exactly when you need them most.</p>
                </div>

                <div class="feature-card fade-in-up delay-2">
                    <div class="feature-icon icon-mobile"></div>
                    <h3 class="feature-title">Cross-Platform Sync</h3>
                    <p class="feature-description">Seamless synchronization across all your devices with native apps that work perfectly on desktop, mobile, and web.</p>
                </div>

                <div class="feature-card fade-in-up delay-3">
                    <div class="feature-icon icon-sparkles"></div>
                    <h3 class="feature-title">Advanced Analytics</h3>
                    <p class="feature-description">Deep insights into your team's productivity with beautiful reports and analytics that help optimize your workflow.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern CTA Section -->
    <section class="cta">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Transform Your Team?</h2>
            <p class="cta-subtitle">Join thousands of forward-thinking teams who have revolutionized their productivity with Unity Calendar's cutting-edge platform.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-cta">Start Your Free Trial</a>
            @endif
        </div>
    </section>

    <!-- Modern Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div>
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Unity Calendar" class="logo-img">
                        Unity Calendar
                    </div>
                    <p class="footer-description">The modern calendar platform that transforms how teams collaborate and manage events with intelligent scheduling and seamless integration.</p>
                </div>

                <div class="footer-section">
                    <h3>Product</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#integrations">Integrations</a></li>
                        <li><a href="#api">API</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="#about">About</a></li>
                        <li><a href="#careers">Careers</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#press">Press</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li><a href="#help">Help Center</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#status">Status</a></li>
                        <li><a href="#security">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 Unity Calendar. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Modern JavaScript with smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu functionality
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileNav = document.getElementById('mobileNav');

            if (mobileMenuBtn && mobileNav) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileNav.classList.toggle('active');
                    // Change hamburger to X
                    if (mobileNav.classList.contains('active')) {
                        mobileMenuBtn.innerHTML = '✕';
                    } else {
                        mobileMenuBtn.innerHTML = '☰';
                    }
                });

                // Close mobile menu when clicking on links
                const mobileLinks = document.querySelectorAll('.mobile-nav-link');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        mobileNav.classList.remove('active');
                        mobileMenuBtn.innerHTML = '☰';
                    });
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuBtn.contains(event.target) && !mobileNav.contains(event.target)) {
                        mobileNav.classList.remove('active');
                        mobileMenuBtn.innerHTML = '☰';
                    }
                });
            }

            // Header scroll effect
            const header = document.getElementById('header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all fade-in elements
            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
            });

            // Interactive calendar
            const calendarDays = document.querySelectorAll('.calendar-day:not(.header)');
            const colors = ['event', 'event-secondary', 'event-accent'];

            calendarDays.forEach(day => {
                day.addEventListener('click', function() {
                    if (!this.classList.contains('today') && !this.classList.contains('event') &&
                        !this.classList.contains('event-secondary') && !this.classList.contains('event-accent')) {

                        const randomColor = colors[Math.floor(Math.random() * colors.length)];
                        this.classList.add(randomColor);

                        // Remove the class after 3 seconds
                        setTimeout(() => {
                            this.classList.remove(randomColor);
                        }, 3000);
                    }
                });
            });

            // Add floating animations to feature cards
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-12px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Animate feature items on scroll
            const featureItems = document.querySelectorAll('.feature-item');

            const featuresObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            });

            featureItems.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                featuresObserver.observe(item);
            });

            // Add parallax effect to floating cards
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.floating-card');

                parallaxElements.forEach((element, index) => {
                    const speed = 0.1 + (index * 0.05);
                    const yPos = -(scrolled * speed);
                    element.style.transform = `translate3d(0, ${yPos}px, 0)`;
                });
            });
        });
    </script>
</body>
</html>