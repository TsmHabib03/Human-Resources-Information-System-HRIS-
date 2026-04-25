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

