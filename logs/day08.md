# Day 8/100

✅ Refonte UI des pages d’auth (layout dédié, split 50/50, bouton GitHub désactivé, FR)  
✅ Amélioration composants `x-ui.button` (variants/sizes + slot) et `x-ui.input` (toggle mot de passe)  
✅ Domaine Challenges: nouveaux modèles ULID (`ChallengeRun`, `DailyLog`, `ChallengeParticipant`, `ChallengeInvitation`) + migrations  
✅ Migration legacy: rebrancher `Challenge` → `DailyLog` et outils de migration des données  
✅ Pages Livewire Challenges: index (création), show (progression, streak, invitations, calendrier 100 jours), accept d’invitation  
✅ Dashboard: aligné sur le challenge actif (progression perso, lien direct), projets filtrés par run  
✅ Page Projets: filtrée par run actif + rattachement automatique des nouveaux projets  
✅ Journal du jour: démarrage explicite (plus d’auto-création du run), redirection vers /challenges

**Réflexion :**  
Grosse itération structurante aujourd’hui: passage à un modèle “challenge” propre et extensible, UI auth soignée et ergonomie améliorée. Les bases pour le multi-participants (invitation, progression, calendrier) sont en place. Prochaines étapes: amélioration du streak (record vs courant), gestion fine des invitations (révocation/renvoi), et un sélecteur de challenge sur le Dashboard.
