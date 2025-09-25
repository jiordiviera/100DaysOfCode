# Day 12/100

- Rebuilt the auth experience: Livewire login/register forms now lean on Filament, with forgot/reset flows and notifications covering success/error states.
- Hardened challenge management by blocking concurrent runs for owners, surfacing warnings in the UI, and ensuring invites respect the "one active challenge" rule.
