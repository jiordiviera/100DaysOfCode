# Day 69/100

## 🚀 Résumé de la journée
Une nouvelle journée productive dans le cadre du défi #100DaysOfCode. Le focus principal a été l'implémentation d'un système d'authentification robuste via le 'double cookie pattern' et les JWT. Avec plus de 9 heures de travail, l'effort s'est réparti entre les écosystèmes Next.js (TypeScript) et Laravel (PHP). La performance est excellente en termes de volume et de complexité technique abordée.

---

## Jour X: Focus sur la Sécurité des Sessions et JWT
### ⏱️ Bilan de la Session
- Temps total: 9 hrs 14 mins
- Top Technologie: TypeScript (Next.js) & PHP (Laravel)
- Focus: Sécurité des sessions avec le 'double cookie pattern' et JWT
### 📝 Notes et Commits
Une nouvelle journée productive dans le cadre du défi #100DaysOfCode, avec un focus principal sur l'implémentation d'un système d'authentification robuste via le 'double cookie pattern' et les JWT. Avec plus de 9 heures de travail, l'effort s'est réparti entre les écosystèmes Next.js (TypeScript) et Laravel (PHP), démontrant une excellente performance en termes de volume et de complexité technique abordée. Cependant, plus de 9 heures de code est un marathon ; il est crucial de se rappeler que des pauses régulières sont essentielles pour maintenir cette performance sur la durée.

**Commits du jour :**
* [feat: Implement double cookie security for session management](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/b7e825a3e15aad965a84f77be54afbcc4baaf540)
* [Add refresh token and expiration date to Company model](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/ccc3da02efa11f24dfcc3c3aa9f5dccf5f2193c3)
* [Update README with React component usage examples](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/6616f4d3f50c14edcba2803bcfe8e945de84f46a)
* [feat: Implement authentication context and provider](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/d15078aabac51ac73eefa60f408da3dec71ab5c1)
* [feat: Implement double cookie pattern for session](https://github.com/usegenuka/genuka-laravel-boilerplate/commit/07637e3755a46310c93d0952750c8d539bf422f4)
* [Add refresh token and token expiration to Company model](https://github.com/usegenuka/genuka-laravel-boilerplate/commit/fc321d7ff47d8782077f3d36c76a4bf3e4aeaf10)

---
### ⏱️ WakaTime
- Temps codé total : **9 hrs 14 mins**
- Projets : **genuka-api** (1 hr 45 mins), **buroo** (1 hr 8 mins), **genuka-dev-platform** (1 hr 3 mins), **genuka-php** (1 hr 3 mins), **genuka-express-boilerplate** (55 mins), **genuka-django-boilerplate** (34 mins), **genuka-dashboard** (31 mins), **Unknown Project** (27 mins), **genuka-package** (23 mins), **genuka-nuxt-boilerplate** (18 mins), **genuka-nextjs-boilerplate** (18 mins), **cd** (11 mins), **genuka-laravel-boilerplate** (10 mins), **zed-laravel-blade** (9 mins), **zed-for-laravel** (8 mins), **php** (1 min), **zed** (58 secs), **livewire-ui-lab** (38 secs), **centi** (29 secs), **documentation** (11 secs)
- Langages : **Other** (4 hrs 17 mins), **PHP** (1 hr 39 mins), **TypeScript** (1 hr 6 mins), **Markdown** (34 mins), **JSON** (23 mins), **Bash** (14 mins), **YAML** (12 mins), **Python** (12 mins), **shell script** (10 mins), **jsonc** (8 mins), **JavaScript** (5 mins), **Log** (3 mins), **HTML** (2 mins), **Vue.js** (1 min), **Prisma** (55 secs), **git ignore** (50 secs), **log** (34 secs), **SQL** (13 secs), **Caddyfile** (7 secs), **Blade Template** (0 secs)
### 📝 Commits
- feat: Implement double cookie security for session management  This commit implements a double cookie security pattern for secure session management, using HTTP-only cookies and JWTs. This also includes the implementation of a refresh token to renew session without requiring the user to reinstall the app.  - Implemented secure HTTP-only cookies - Added JWT session management with `jose` - Implemented `refresh` API endpoint - Added `auth` helper functions - Updated `README.md` ([lien](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/b7e825a3e15aad965a84f77be54afbcc4baaf540))
- Add refresh token and expiration date to Company model ([lien](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/ccc3da02efa11f24dfcc3c3aa9f5dccf5f2193c3))
- Update README with React component usage examples  Updated the README to include examples for using the `AuthProvider` and `useAuthStore` hook in React components. Also included notes about handling 401 errors. ([lien](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/6616f4d3f50c14edcba2803bcfe8e945de84f46a))
- feat: Implement authentication context and provider  Adds the AuthProvider component to manage authentication state and provides the useAuthStore hook for accessing it.  Includes checkAuth, refresh, and logout methods for session management. ([lien](https://github.com/usegenuka/genuka-nextjs-boilerplate/commit/d15078aabac51ac73eefa60f408da3dec71ab5c1))
- feat: Implement double cookie pattern for session  Uses a refresh token in a separate cookie for secure session management. ([lien](https://github.com/usegenuka/genuka-laravel-boilerplate/commit/07637e3755a46310c93d0952750c8d539bf422f4))
- Add refresh token and token expiration to Company model ([lien](https://github.com/usegenuka/genuka-laravel-boilerplate/commit/fc321d7ff47d8782077f3d36c76a4bf3e4aeaf10))
- feat: Implement JWT session management and double cookie security  - Implemented JWT-based session management for secure session handling. - Introduced a double cookie security pattern: `session` and `refresh_session`. - Added authentication endpoints: `/api/auth/check`, `/api/auth/me`, `/api/auth/logout` and `/api/auth/refresh`. - Added a secure session refresh mechanism. - Updated documentation and example usage. - Refactored OAuthService to store refresh_token and expiry. ([lien](https://github.com/usegenuka/genuka-laravel-boilerplate/commit/c7add1216a0b51fd7c66b5c9dc247234cd7d633e))
- feat: Add controllers for auth-related operations ([lien](https://github.com/usegenuka/genuka-laravel-boilerplate/commit/b69b0aed2742a9730910651c3eee3f9931fbc425))
- feat: Implement session refresh using refresh tokens  This commit introduces a secure session refresh mechanism using refresh tokens, allowing clients to renew their sessions without requiring the user to reinstall the app.  Key changes: - Added a new POST /api/auth/refresh endpoint - Implemented a double cookie system to manage session and refresh tokens securely - Refactored OAuthService to fetch both access and refresh tokens - Updated the database schema to store refresh tokens and access token expiration dates - Added a JavaScript client example for frontend integration. ([lien](https://github.com/usegenuka/genuka-express-boilerplate/commit/a0750b6db6a8c5af3d6a0a4f59d8f24b26da77c8))
- feat: Implement authentication and authorization  This commit introduces authentication and authorization functionality for the application, including:  - Session management using JWTs. - Authentication middleware to protect routes. - Logout functionality. - Methods to check and refresh sessions. - Auth controllers to handle authentication-related requests. - Express types for accessing company info in requests. ([lien](https://github.com/usegenuka/genuka-express-boilerplate/commit/53f595756842608c1981b3315590fa8fc6d0faa3))

