<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Unity Group Calendar</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.5rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-blue);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 3rem;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: var(--dark-gray);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
            font-weight: 600;
        }

        .stat-card:nth-child(1) .stat-icon { background: var(--primary-blue); }
        .stat-card:nth-child(2) .stat-icon { background: var(--primary-green); }
        .stat-card:nth-child(3) .stat-icon { background: var(--primary-yellow); color: #1a1a1a; }
        .stat-card:nth-child(4) .stat-icon { background: var(--primary-red); }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--primary-blue);
            color: white;
        }

        .btn-primary:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }

        .btn-outline:hover {
            background: var(--primary-blue);
            color: white;
        }

        .btn-danger {
            background: var(--primary-red);
            color: white;
        }

        .btn-danger:hover {
            background: #d33;
            transform: translateY(-2px);
        }

        .recent-users {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .recent-users-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .user-list {
            list-style: none;
        }

        .user-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background 0.3s ease;
        }

        .user-item:hover {
            background: rgba(66, 133, 244, 0.1);
        }

        .user-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-item-avatar {
            width: 35px;
            height: 35px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .user-name {
            font-weight: 600;
            color: #1a1a1a;
        }

        .user-email {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }

        .user-role {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .role-admin {
            background: rgba(234, 67, 53, 0.1);
            color: var(--primary-red);
        }

        .role-user {
            background: rgba(52, 168, 83, 0.1);
            color: var(--primary-green);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1.5rem;
                margin: 0.5rem;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .user-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
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

    <div class="dashboard-container">
        <header class="header">
            <div class="logo">
                <div class="logo-icon">UC</div>
                <span class="logo-text">Unity Calendar</span>
            </div>
            <div class="user-info">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <div style="font-weight: 600; color: #1a1a1a;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 0.8rem; color: #5f6368;">Administrator</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-left: 1rem;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="welcome-message">
            <h1 class="welcome-title">Admin Dashboard</h1>
            <p class="welcome-subtitle">Manage your Unity Group Calendar system</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👑</div>
                <div class="stat-number">{{ $totalAdmins }}</div>
                <div class="stat-label">Administrators</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number">{{ $activeUsers }}</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-number">{{ $totalUsers + $totalAdmins }}</div>
                <div class="stat-label">Total Accounts</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                👥 Manage Users
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline">
                ➕ Create User
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline">
                🏠 User Dashboard
            </a>
        </div>

        @if($recentUsers->count() > 0)
        <div class="recent-users">
            <h2 class="recent-users-title">Recent Users</h2>
            <ul class="user-list">
                @foreach($recentUsers as $user)
                <li class="user-item">
                    <div class="user-details">
                        <div class="user-item-avatar">{{ substr($user->name, 0, 1) }}</div>
                        <div>
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="user-role role-{{ $user->role }}">{{ $user->role }}</div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</body>
</html>