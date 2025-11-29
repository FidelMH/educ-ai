# Configuration du Chatbot Educ-AI

## 📋 Prérequis

- PHP 8.2+
- Composer
- Laravel 12
- Compte Groq API ([groq.com](https://groq.com))
- Package `openai-php/laravel` installé

## 🔧 Installation & Configuration

### 1. Variables d'environnement

Copiez `.env.example` vers `.env` et configurez les variables suivantes :

```env
# Groq API Configuration
GROQ_API_KEY=gsk_votre_clé_api_ici
OPENAI_BASE_URL=https://api.groq.com/openai/v1
OPENAI_REQUEST_TIMEOUT=30
```

### 2. Obtenir une clé API Groq

1. Créez un compte sur [console.groq.com](https://console.groq.com)
2. Allez dans "API Keys"
3. Créez une nouvelle clé
4. Copiez la clé dans votre fichier `.env`

### 3. Migrations

Si ce n'est pas déjà fait, exécutez les migrations :

```bash
php artisan migrate
```

Les migrations importantes pour le chatbot :
- `2025_11_27_095850_add_user_id_to_discusses_table.php`
- `2025_11_27_100621_make_user_id_nullable_in_messages_table.php`

### 4. Vérifier la configuration

Vérifiez que le package OpenAI est bien configuré :

```bash
php artisan tinker
```

```php
$client = \OpenAI::client(config('openai.api_key'));
// Si aucune erreur, la configuration est correcte
```

## 🚀 Utilisation

### Accéder au chatbot

1. Connectez-vous en tant qu'utilisateur (pas admin)
2. Accédez à `/chat`
3. Cliquez sur "Nouvelle conversation"
4. Sélectionnez un agent (matière)
5. Commencez à discuter !

### Routes disponibles

```
GET    /chat                     → Page principale du chatbot
GET    /chat/{discuss}           → Conversation spécifique
POST   /chat/create              → Créer une nouvelle conversation
DELETE /chat/{discuss}           → Supprimer une conversation
POST   /chat/{discuss}/message   → Envoyer un message (AJAX)
```

## 🎨 Différences Chat vs Admin

| Aspect | `/chat` (Utilisateur) | `/dashboard/discuss` (Admin) |
|--------|----------------------|------------------------------|
| Layout | `<x-public-layout>` | `<x-app-layout>` |
| Accès | Tous les utilisateurs | Admin uniquement |
| Design | Moderne, gradient bleu | Style admin, sobre |
| Fonctionnalités | Chat en temps réel, IA | CRUD des discussions |

## 🔒 Sécurité

- **Autorisation :** Chaque utilisateur ne peut accéder qu'à ses propres conversations
- **Validation :** Messages limités à 1000 caractères
- **XSS Protection :** Échappement HTML côté frontend
- **CSRF Protection :** Token CSRF sur toutes les requêtes POST

## 📊 Structure de la base de données

### Table `discusses`
```
- id
- user_id (FK vers users) ← Ajouté
- agent_id (FK vers agents)
- created_at
- updated_at
```

### Table `messages`
```
- id
- discuss_id (FK vers discusses)
- user_id (FK vers users, nullable) ← Modifié
- agent_id (FK vers agents)
- type_message ('user' | 'assistant')
- message (text)
- created_at
- updated_at
```

## 🤖 Modèle AI utilisé

- **Provider :** Groq
- **Modèle :** `openai/gpt-oss-20b`
- **Température :** 0.7 (équilibre créativité/précision)
- **Max tokens :** 1000
- **Contexte :** 20 derniers messages

## 🐛 Dépannage

### Erreur "GROQ_API_KEY not found"
- Vérifiez que `.env` contient `GROQ_API_KEY=...`
- Relancez le serveur : `php artisan serve`

### Erreur "Class 'OpenAI' not found"
- Installez le package : `composer require openai-php/laravel`
- Publiez la config : `php artisan vendor:publish --provider="OpenAI\Laravel\ServiceProvider"`

### Messages ne s'affichent pas
- Vérifiez la console JavaScript (F12)
- Vérifiez les logs Laravel : `storage/logs/laravel.log`
- Vérifiez que `user_id` est bien nullable dans la table `messages`

### Erreur API Groq
- Vérifiez votre clé API
- Vérifiez votre quota sur console.groq.com
- Consultez les logs : `storage/logs/laravel.log`

### Erreur "model has been decommissioned"
- Groq décommissionne régulièrement certains modèles
- Le modèle actuel est `llama-3.3-70b-versatile`
- Consultez https://console.groq.com/docs/models pour la liste des modèles disponibles

## 📝 Logs

Les erreurs API sont loggées dans :
```
storage/logs/laravel.log
```

Recherchez : `Groq API Error:`

## 🎯 Fonctionnalités implémentées

✅ Authentification et autorisation
✅ Conversations multiples par utilisateur
✅ Sidebar avec liste des conversations
✅ Modal de sélection d'agent
✅ Chat en temps réel (AJAX)
✅ Intégration Groq API
✅ System prompt dynamique par matière
✅ Historique de conversation
✅ Gestion d'erreurs
✅ Design différent de l'admin
✅ Messages utilisateur vs assistant différenciés
✅ Typing indicator
✅ Auto-scroll
✅ Compteur de caractères

## 📚 Documentation

- [Groq API Docs](https://console.groq.com/docs)
- [OpenAI PHP Client](https://github.com/openai-php/client)
- [Laravel Documentation](https://laravel.com/docs)

## 🆘 Support

En cas de problème, consultez :
1. `IMPLEMENTATION_LOG.md` - Historique complet de l'implémentation
2. `CHATBOT_DEVELOPMENT_PLAN.md` - Plan original du projet
3. Les logs Laravel dans `storage/logs/`
