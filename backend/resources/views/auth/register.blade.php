<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        input:focus {
            outline: none;
            border-color: #4CAF50;
        }
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .checkbox-group input[type="checkbox"] {
            margin-top: 3px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .checkbox-group label {
            font-weight: normal;
            cursor: pointer;
        }
        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background: #45a049;
        }
        /* .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        } */
    </style>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Prénom -->
            <div class="form-group">
                <label for="firstname">Prénom *</label>
                <input 
                    type="text" 
                    id="firstname" 
                    name="firstname" 
                    value="{{ old('firstname') }}" 
                    required
                    autofocus
                >
                @error('firstname')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nom -->
            <div class="form-group">
                <label for="lastname">Nom *</label>
                <input 
                    type="text" 
                    id="lastname" 
                    name="lastname" 
                    value="{{ old('lastname') }}" 
                    required
                >
                @error('lastname')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email *</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                >
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirmation mot de passe -->
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe *</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                >
            </div>

            <!-- Consentement -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input 
                        type="checkbox" 
                        id="consentement" 
                        name="consentement" 
                        value="1"
                        {{ old('consentement') ? 'checked' : '' }}
                        required
                    >
                    <label for="consentement">
                        J'accepte les conditions d'utilisation et la politique de confidentialité *
                    </label>
                </div>
                @error('consentement')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bouton -->
            <button type="submit">S'inscrire</button>
        </form>

        <div class="login-link">
            Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>
</body>
</html>