<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h2 {
            color: #333;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .logout-btn {
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: #c0392b;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .welcome-card h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .welcome-card p {
            color: #666;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" style="text-decoration: none; color: #333;">
            <h2>Mon Application</h2>
        </a>
        <div class="user-info">
            <span>Bonjour, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h1>🎉 Bienvenue sur votre Dashboard !</h1>
            <p>Vous êtes connecté avec succès.</p>
            <p><strong>Email :</strong> {{ auth()->user()->email }}</p>
        </div>

        <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <a href="{{ route('dashboard.agents.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">🤖</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Agents</h3>
                    <p style="color: #666; font-size: 14px;">Créer et gérer vos agents IA</p>
                </div>
            </a>

            <a href="{{ route('dashboard.discuss.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">💬</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Discussions</h3>
                    <p style="color: #666; font-size: 14px;">Gérer les discussions avec les agents</p>
                </div>
            </a>

            <a href="{{ route('dashboard.messages.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">✉️</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Messages</h3>
                    <p style="color: #666; font-size: 14px;">Consulter et gérer tous les messages</p>
                </div>
            </a>

            <a href="{{ route('dashboard.roles.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">👥</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Rôles</h3>
                    <p style="color: #666; font-size: 14px;">Gérer les rôles utilisateurs</p>
                </div>
            </a>

            <a href="{{ route('dashboard.levels.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">📊</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Niveaux</h3>
                    <p style="color: #666; font-size: 14px;">Gérer les niveaux de difficulté</p>
                </div>
            </a>

            <a href="{{ route('dashboard.subjects.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">📚</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Matières</h3>
                    <p style="color: #666; font-size: 14px;">Gérer les matières d'étude</p>
                </div>
            </a>

            <a href="{{ route('dashboard.users.index') }}" style="text-decoration: none;">
                <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s;">
                    <div style="font-size: 48px; margin-bottom: 15px;">👤</div>
                    <h3 style="color: #333; margin-bottom: 10px;">Gestion des Utilisateurs</h3>
                    <p style="color: #666; font-size: 14px;">Gérer les comptes utilisateurs</p>
                </div>
            </a>
        </div>
    </div>

    <style>
        a div:hover {
            transform: translateY(-5px);
        }
    </style>
</body>
</html>