FROM node:20-alpine

# Définir le répertoire de travail
WORKDIR /app

# Copier package.json et package-lock.json
COPY package*.json ./

# Installer les dépendances
RUN npm install

# Copier tout le reste du projet
COPY . .

# Exposer les ports (juste pour la documentation)
EXPOSE 5175 3000

# Commande par défaut : Empêche le conteneur de s'arrêter immédiatement
# Cette commande N'EST PAS un serveur.
CMD ["sh", "-c", "tail -f /dev/null"]