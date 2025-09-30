# Day 15/100

- Linked the CI and CD workflows so production deploys wait for a clean test run and handle service reload permissions gracefully.
- Auto-enrolled challenge owners and invitees in their runs, creating default profiles to skip redundant onboarding prompts.
- Surfaced pending invitations inside the onboarding flow with one-click acceptance and added feature tests guarding the invitation journey.

**Reflection:**
Today tightened the loop from automation to user experience: the pipeline now deploys safely only after passing tests, while the app better recognises invited members and guides them straight into a challenge. Tomorrow I want to focus on streak metrics and polishing the challenge dashboard with the new participant context.
