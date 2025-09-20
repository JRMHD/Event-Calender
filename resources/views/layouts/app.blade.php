<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Unity Group Calendar')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #4285F4;
            --primary-green: #34A853;
            --primary-yellow: #FBBC04;
            --primary-red: #EA4335;
            --dark-blue: #1a73e8;
            --light-gray: #f8f9fa;
            --dark-gray: #5f6368;
            --white: #ffffff;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 15%;
            left: 85%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 80px;
            height: 80px;
            top: 70%;
            right: 10%;
            animation-delay: 3s;
        }

        .floating-element:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 30%;
            right: 20%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(180deg); }
        }

        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1001;
            transition: transform 0.3s ease;
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.25rem;
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        .logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .nav-menu {
            flex: 1;
            padding: 2rem 1.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: var(--dark-gray);
            font-weight: 500;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-item:hover {
            background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(66, 133, 244, 0.05) 100%);
            color: var(--primary-blue);
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
        }

        .nav-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .user-info-sidebar {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(52, 168, 83, 0.1) 100%);
            border-radius: 12px;
        }

        .user-avatar-sidebar {
            width: 45px;
            height: 45px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(52, 168, 83, 0.3);
        }

        .user-details-sidebar {
            flex: 1;
        }

        .user-name-sidebar {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .user-email-sidebar {
            font-size: 0.75rem;
            color: var(--dark-gray);
            margin-bottom: 0.25rem;
        }

        .user-role-sidebar {
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            background: rgba(52, 168, 83, 0.1);
            color: var(--primary-green);
            display: inline-block;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-header {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-blue);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: rgba(66, 133, 244, 0.1);
        }

        .mobile-user-dropdown {
            display: none;
            position: relative;
        }

        .mobile-user-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(66, 133, 244, 0.2);
            border-radius: 12px;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-user-button:hover {
            border-color: var(--primary-blue);
            background: rgba(255, 255, 255, 1);
        }

        .mobile-user-avatar {
            width: 30px;
            height: 30px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .mobile-dropdown-content {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-width: 200px;
            z-index: 1002;
            transform: translateY(-10px) scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .mobile-dropdown-content.show {
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }

        .mobile-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .mobile-dropdown-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .mobile-dropdown-email {
            font-size: 0.75rem;
            color: var(--dark-gray);
            margin-bottom: 0.25rem;
        }

        .mobile-dropdown-role {
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            background: rgba(52, 168, 83, 0.1);
            color: var(--primary-green);
            display: inline-block;
        }

        .mobile-dropdown-actions {
            padding: 0.5rem;
        }

        .mobile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            text-decoration: none;
            color: #1a1a1a;
            border-radius: 8px;
            transition: background 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .mobile-dropdown-item:hover {
            background: rgba(66, 133, 244, 0.1);
            color: var(--primary-blue);
        }

        .mobile-dropdown-item.logout {
            color: var(--primary-red);
        }

        .mobile-dropdown-item.logout:hover {
            background: rgba(234, 67, 53, 0.1);
            color: var(--primary-red);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .header-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .desktop-user-dropdown {
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 12px;
            transition: background 0.3s ease;
        }

        .desktop-user-dropdown:hover {
            background: rgba(66, 133, 244, 0.1);
        }

        .desktop-dropdown-content {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-width: 250px;
            z-index: 1002;
            transform: translateY(-10px) scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .desktop-dropdown-content.show {
            display: block;
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }

        .desktop-dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .desktop-dropdown-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .desktop-dropdown-email {
            font-size: 0.75rem;
            color: var(--dark-gray);
            margin-bottom: 0.25rem;
        }

        .desktop-dropdown-role {
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            background: rgba(52, 168, 83, 0.1);
            color: var(--primary-green);
            display: inline-block;
        }

        .desktop-dropdown-actions {
            padding: 0.5rem 0;
        }

        .desktop-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #1a1a1a;
            text-decoration: none;
            transition: background 0.3s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .desktop-dropdown-item:hover {
            background: rgba(66, 133, 244, 0.1);
        }

        .desktop-dropdown-item:last-child {
            border-bottom: none;
            border-radius: 0 0 12px 12px;
        }

        .desktop-dropdown-item svg {
            width: 16px;
            height: 16px;
        }

        .desktop-dropdown-item button {
            background: none;
            border: none;
            color: inherit;
            font: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            text-align: left;
        }

        .user-avatar-header {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .user-avatar-header:hover {
            transform: scale(1.1);
        }

        .user-details-header {
            display: flex;
            flex-direction: column;
        }

        .user-name-header {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.9rem;
        }

        .user-email-header {
            font-size: 0.75rem;
            color: var(--dark-gray);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-header {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-outline-header {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }

        .btn-outline-header:hover {
            background: var(--primary-blue);
            color: white;
        }

        .btn-primary-header {
            background: var(--primary-green);
            color: white;
        }

        .btn-primary-header:hover {
            background: #2d7a3f;
        }

        .content-area {
            flex: 1;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height) - 4rem);
        }

        .header-clock-widget {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1001;
        }

        .clock-icon {
            font-size: 1.2rem;
            color: var(--primary-blue);
            flex-shrink: 0;
        }

        .clock-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .clock-time {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .clock-date {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }

        .clock-separator {
            width: 1px;
            height: 20px;
            background: rgba(0, 0, 0, 0.1);
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        .mobile-nav-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-width: 250px;
            z-index: 1002;
            transform: translateY(-10px) scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .mobile-nav-dropdown.show {
            display: block;
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #1a1a1a;
            text-decoration: none;
            transition: background 0.3s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .mobile-nav-item:hover {
            background: rgba(66, 133, 244, 0.1);
        }

        .mobile-nav-item:last-child {
            border-bottom: none;
            border-radius: 0 0 12px 12px;
        }

        .mobile-nav-item:first-child {
            border-radius: 12px 12px 0 0;
        }

        .mobile-nav-item.active {
            background: rgba(66, 133, 244, 0.1);
            color: var(--primary-blue);
            font-weight: 600;
        }

        .mobile-nav-icon {
            width: 20px;
            height: 20px;
            color: currentColor;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
                position: relative;
            }

            .page-title {
                display: none;
            }

            .header-user-info {
                display: none;
            }

            .mobile-user-dropdown {
                display: block;
            }

            .header-clock-widget {
                position: static;
                transform: none;
                left: auto;
                top: auto;
            }

            .content-area {
                padding: 1rem;
            }

            .top-header {
                padding: 0 1rem;
            }

            .header-clock-widget {
                padding: 0.4rem 0.75rem;
                gap: 0.5rem;
            }

            .clock-time {
                font-size: 0.8rem;
            }

            .clock-date {
                font-size: 0.7rem;
            }

            .clock-icon {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .content-wrapper {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .page-title {
                font-size: 1.1rem;
            }

            .header-clock-widget {
                padding: 0.3rem 0.5rem;
                gap: 0.4rem;
            }

            .clock-content {
                gap: 0.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="{{ asset('images/logo.png') }}" alt="Unity Calendar Logo">
                    </div>
                    <span class="logo-text">Unity Calendar</span>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="nav-item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                    </span>
                    <span>Calendar</span>
                </a>
                <a href="{{ route('events.index') }}" class="nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                    </span>
                    <span>Events</span>
                </a>
                <a href="{{ route('reports.index') }}" class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22,21H2V3H4V19H6V10H10V19H12V6H16V19H18V14H22V21Z"/>
                        </svg>
                    </span>
                    <span>Calendar Reports</span>
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.22,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.22,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.68 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z"/>
                        </svg>
                    </span>
                    <span>Admin Panel</span>
                </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <div class="user-info-sidebar">
                    <div class="user-avatar-sidebar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="user-details-sidebar">
                        <div class="user-name-sidebar">{{ auth()->user()->name }}</div>
                        <div class="user-email-sidebar">{{ auth()->user()->email }}</div>
                        <div class="user-role-sidebar">{{ auth()->user()->role }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header" style="position: relative;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="mobile-menu-toggle">
                        <button onclick="toggleMobileNavDropdown()" style="background: none; border: none; font-size: 1.5rem; color: var(--primary-blue); cursor: pointer; padding: 0.5rem; border-radius: 8px; transition: background 0.3s ease;">
                            ☰
                        </button>
                        <div class="mobile-nav-dropdown" id="mobileNavDropdown">
                            <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <svg class="mobile-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('calendar.index') }}" class="mobile-nav-item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                                <svg class="mobile-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                                Calendar
                            </a>
                            <a href="{{ route('events.index') }}" class="mobile-nav-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
                                <svg class="mobile-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                </svg>
                                Events
                            </a>
                            <a href="{{ route('reports.index') }}" class="mobile-nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                                <svg class="mobile-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M22,21H2V3H4V19H6V10H10V19H12V6H16V19H18V14H22V21Z"/>
                                </svg>
                                Calendar Reports
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                                <svg class="mobile-nav-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.22,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.22,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.68 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z"/>
                                </svg>
                                Admin Panel
                            </a>
                            @endif
                        </div>
                    </div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                </div>

                <!-- Clock Widget in Header Center -->
                <div class="header-clock-widget">
                    <div class="clock-icon">🕐</div>
                    <div class="clock-content">
                        <div class="clock-time" id="clock-time">00:00:00</div>
                        <div class="clock-separator"></div>
                        <div class="clock-date" id="clock-date">Today</div>
                    </div>
                </div>

                <!-- Desktop User Info -->
                <div class="header-user-info">
                    <div class="desktop-user-dropdown" onclick="toggleDesktopUserDropdown()">
                        <div class="user-details-header">
                            <div class="user-name-header">{{ auth()->user()->name }}</div>
                            <div class="user-email-header">{{ auth()->user()->email }} • {{ auth()->user()->role }}</div>
                        </div>
                        <div class="user-avatar-header">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: var(--dark-gray);">
                            <path d="M7 10l5 5 5-5z"/>
                        </svg>
                    </div>
                    <div class="desktop-dropdown-content" id="desktopUserDropdown">
                        <div class="desktop-dropdown-header">
                            <div class="desktop-dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="desktop-dropdown-email">{{ auth()->user()->email }}</div>
                            <div class="desktop-dropdown-role">{{ auth()->user()->role }}</div>
                        </div>
                        <div class="desktop-dropdown-actions">
                            <a href="{{ route('profile.edit') }}" class="desktop-dropdown-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Profile Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <div class="desktop-dropdown-item">
                                    <button type="submit">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                        </svg>
                                        Logout
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile User Dropdown -->
                <div class="mobile-user-dropdown">
                    <button class="mobile-user-button" onclick="toggleMobileUserDropdown()">
                        <div class="mobile-user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color: #5f6368;">
                            <path d="M7 10l5 5 5-5z"/>
                        </svg>
                    </button>

                    <div class="mobile-dropdown-content" id="mobileUserDropdown">
                        <div class="mobile-dropdown-header">
                            <div class="mobile-dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="mobile-dropdown-email">{{ auth()->user()->email }}</div>
                            <div class="mobile-dropdown-role">{{ auth()->user()->role }}</div>
                        </div>

                        <div class="mobile-dropdown-actions">
                            <a href="{{ route('profile.edit') }}" class="mobile-dropdown-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                Profile Settings
                            </a>

                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="mobile-dropdown-item logout" style="width: 100%; background: none; border: none; text-align: left;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        // Mobile navigation dropdown toggle
        function toggleMobileNavDropdown() {
            const dropdown = document.getElementById('mobileNavDropdown');
            dropdown.classList.toggle('show');
        }

        // Close mobile nav dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('mobileNavDropdown');
            const toggleButton = event.target.closest('.mobile-menu-toggle');

            if (!toggleButton && dropdown) {
                dropdown.classList.remove('show');
            }
        });

        // Desktop user dropdown toggle
        function toggleDesktopUserDropdown() {
            const dropdown = document.getElementById('desktopUserDropdown');
            dropdown.classList.toggle('show');
        }

        // Mobile user dropdown toggle
        function toggleMobileUserDropdown() {
            const dropdown = document.getElementById('mobileUserDropdown');
            dropdown.classList.toggle('show');
        }

        // Close user dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const desktopDropdown = document.getElementById('desktopUserDropdown');
            const mobileDropdown = document.getElementById('mobileUserDropdown');
            const desktopButton = document.querySelector('.desktop-user-dropdown');
            const mobileButton = document.querySelector('.mobile-user-button');

            // Close desktop dropdown
            if (desktopDropdown && desktopButton && !desktopButton.contains(event.target) && !desktopDropdown.contains(event.target)) {
                desktopDropdown.classList.remove('show');
            }

            // Close mobile dropdown
            if (mobileDropdown && mobileButton && !mobileButton.contains(event.target) && !mobileDropdown.contains(event.target)) {
                mobileDropdown.classList.remove('show');
            }
        });

        // Clock functionality
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const dateString = now.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            document.getElementById('clock-time').textContent = timeString;
            document.getElementById('clock-date').textContent = dateString;
        }

        // Update clock every second
        setInterval(updateClock, 1000);
        updateClock(); // Initial call

        // Close dropdowns on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const navDropdown = document.getElementById('mobileNavDropdown');
                const mobileUserDropdown = document.getElementById('mobileUserDropdown');
                if (navDropdown) navDropdown.classList.remove('show');
                if (mobileUserDropdown) mobileUserDropdown.classList.remove('show');
            } else {
                const desktopUserDropdown = document.getElementById('desktopUserDropdown');
                if (desktopUserDropdown) desktopUserDropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>