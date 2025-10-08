# Day 21/100

## 🚀 Résumé de la journée
Objectif du jour : automatiser totalement le déploiement de **100DaysOfCode·AI Coach** 🎯

### 🔧 Ansible / Serveur
- Ajout des handlers manquants (`restart php-fpm`, `restart sshd`)
- Passage à **PHP 8.4**
- Fix PostgreSQL (`postgresql_privs` + suppression de `priv`)
- Sécurisation de `known_hosts` avec les clés GitHub officielles
- Ajustement des permissions `deploy` ↔ `www-data`
- Provisionnement du VPS Hetzner (PostgreSQL, Redis, PHP)

### 🌐 Application
- Déploiement sur **100days.jiordiviera.me**
- Configuration du domaine, `.env`, SSL Let’s Encrypt
- Build des assets avec **Bun**
- Résolution des dépendances manquantes

### ⚙️ CI/CD – GitHub Actions
- Workflow `deploy.yml` opérationnel
- Lancement Ansible depuis GitHub Actions
- Gestion des secrets et des clés SSH
- Correction des erreurs de conditions `if: secrets`

## 💡 Réflexion
Premier déploiement full-automatisé réussi ✅  
L’infrastructure est stable, le pipeline CI/CD tourne comme prévu, et la prod est enfin prête à accueillir les prochaines features.

---
