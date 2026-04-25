<<<<<<< HEAD
# Minimalist Government-Style Redesign - TODO

## Goal
Make the landing page and marketing CSS look simple, minimalist, and modern with a government portal aesthetic (like GOV.UK / Philippines eGov). Clean geometric icons, flat design, no decorative blobs or neon green.

## Steps

### 1. Redesign `public/assets/css/marketing.css`
- [ ] Remove neon green (`rgb(61, 233, 14)`), backdrop-filters, blur, heavy shadows, radial gradients
- [ ] Replace with flat 1px borders, government navy/blue palette (`--gov-blue`, `--gov-ink-*`)
- [ ] Flatten buttons, badges, cards — solid colors only, small radii
- [ ] Remove psychology gimmicks: confidence meters, shimmers, pulses
- [ ] Keep scroll-reveal but make subtler
- [ ] Update responsive breakpoints

### 2. Simplify `app/views/public/landing.php`
- [ ] Replace generic SVGs with clean geometric government-style icons
- [ ] Flatten hero: remove glassmorphism side panel, use clean bordered box
- [ ] Simplify social proof to flat numbers with borders
- [ ] Convert bento cards to clean bordered feature boxes (no hover transforms)
- [ ] Simplify module matrix to clean table
- [ ] Flatten CTA section

### 3. Update `app/views/public/pricing.php` to match
- [ ] Simplify plan cards to 1px bordered boxes
- [ ] Remove confidence meters and shimmer effects
- [ ] Flatten comparison table and FAQ

### 4. QA & Cleanup
- [ ] Verify zero neon green / purple remains in CSS
- [ ] Verify all CSS classes used in PHP are defined
- [ ] Check contrast accessibility
- [ ] Verify responsive behavior
=======
# Billing & Subscription — Government Design + Feature Lock

## Plan
- [x] 1. Research existing billing/lock CSS, JS, sidebar, layout, and helpers
- [x] 2. Redesign `billing.css` with government tokens (navy blue + teal, sharp edges)
- [x] 3. Redesign `lock-modal.css` with government tokens and sharp edges
- [x] 4. Update `app/views/layouts/app.php` to load billing.css, lock-modal.css, and lock-modal.js
- [x] 5. Update `app/views/partials/sidebar.php` to show Billing nav + subscription-locked items with lock icon/modal trigger
- [x] 6. Add `nav-link-locked` / `nav-link-lock` styles to `layout.css`
- [x] 7. Add `billing.view` + `billing.manage` to HR Admin role seed
- [x] 8. Verify lock-modal.js handles dynamically injected triggers (delegation — already supported)
- [x] 9. Complete
>>>>>>> 9c319381b75720d65420a7d3633410b0c1a1b111

