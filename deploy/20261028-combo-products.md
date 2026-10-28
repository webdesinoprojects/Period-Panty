# Combo product images and Teen copy — 28 October

## Applied in the working copy

- Cotton Period Panty pack of 2 (existing slug `cotton-period-panty-pack-of-2`, existing price 899): replace the old gallery with the supplied pink-box / maroon-and-black pack image.
- Seamless Period Panty pack of 2 (existing slug `seamless-period-panty-pack-of-2`, existing price 1599): use both supplied black/pink-package images, white background first and warm background second. Replace old description text with the exact supplied Seamless copy, including its extra-heavy-flow backup guidance; remove the old description to prevent duplicate/conflicting copy.
- Existing Teen singles: apply the supplied Cotton Teen description, 40–60 ml value, XS–XL range and colour-list copy. Keep the existing 550 prices. The copy migration initially adds a missing XL with zero stock; the subsequent approved-stock migration now sets each existing Teen XL to the user-confirmed 100 and recalculates the corresponding parent totals. Other existing sizes are unchanged.
- Image URL rendering is shared across product cards, gallery, cart, checkout and account order thumbnails. Files are saved in both the deploy uploads directory and versioned media directory so local bind mounts can serve the same pictures.
- Keep the 1350 pack of 3 unchanged, as discussed. The separate approval migration now adds the confirmed Teen pack-of-2 at 1100 (two times the 550 single price), with 100 packs in each of XS, S, M, L and XL. It uses the generated green package image and supplied Teen copy. No existing product/variation IDs are recreated, and orders/users are not changed. Original photo files are retained; only the two affected pack galleries are replaced by the guarded migration.

## Approval received and remaining catalogue data

- The user subsequently confirmed “double of single” and “stock 100”. Teen pack-of-2 is therefore 1100, stock 100 per size, 500 total packs. Its URL is `/combo/cotton-teen-period-panty-pack-of-2.html`. The migration guard prevents later page loads from resetting stock sold after this initial approval.
- Lavender, Black, Navy Blue and Maroon single-product variants are not invented from description text alone: supplied copy lists the range, while actual single listings still reflect the existing red/wine products. Confirm matching product photos and stock before expanding/replacing colour variants. The existing Red item is retained rather than silently renamed to another colour.

## Files and rollout

The separate migration `20261028_combo_gallery_teen_copy_v1` runs through `Site_refresh_model` once. Its SQL is `application/models/sql/20261028_combo_gallery_teen_copy.sql`. The later approval is independently guarded as `20261028_teen_combo_approved_v1` with SQL `application/models/sql/20261028_teen_combo_approved.sql`, so it also applies when the previous copy migration has already run. CMS edits made after each migration remain preserved.

Assets, supplied unedited unless noted:

- `assets/front/media/dx-combo-pack-v2.jpg` (Cotton)
- `assets/front/media/dx-combo-seamless-pack2-v1.jpg` (Seamless white)
- `assets/front/media/dx-combo-seamless-pack2-warm-v1.jpg` (Seamless warm)
- `assets/front/media/dx-combo-teen-pack2-v1.jpg` (new generated green Teen pack, now linked to the approved 1100 combo)

Copies also exist under `uploads/product/` for deployment/admin compatibility.

## Teen artwork generation

Used the built-in image-generation tool, not an API/CLI fallback. The requested ivory/deep-green box is shown with exactly two unworn briefs, without a person or body photograph. Full prompt:

Use case: product-mockup / compositing. Create a premium square e-commerce packshot on a clean warm-white background. Reference image 1 is the requested DEXTE ivory-and-deep-green packaging design: preserve the green/cream colour scheme and gold DEXTE brand identity. Show ONE front-facing three-quarter-view box, not two front/back boxes, and remove the screenshot black bars. In front of the box place EXACTLY TWO unworn cotton period briefs neatly laid out, one wine and one maroon, with small gold DEXTE branding. Reference image 2 is the desired product-only box-plus-two-briefs composition and realistic fabric quality; do NOT use its pink box. Replace any body/model photograph printed on the green box with a clean illustration or photograph of the two flat briefs. No people, faces, bodies or mannequins in the scene or on the package. Main readable packaging text: 'DEXTE', 'Cotton Teen Period Panty', 'PACK OF 2'. Do not invent absorbency numbers, wear-time promises, certification badges or extra medical claims. Soft studio light, realistic stitching, natural shadows, all garments and box fully inside the frame. No captions or price outside the package. Keep it clearly a product bundle of two garments.

## Validation

`node application/views/tests/combo_catalogue.cjs` checks supplied copy, gallery targets, both Seamless images, the original zero-stock XL staging step and consistent product/card/cart references. `node application/views/tests/teen_combo_approved.cjs` checks the subsequent 1100 pack, five 100-stock variations, confirmed XL stock, duplicate guards, parent stock aggregation and preserved existing product prices. The existing needs-image, bulk-form and size-price JavaScript regressions also pass. Live database replay and PHP execution are not claimed: this session still lacks access to the local application/Docker control pipe. No commit, push or deployment performed.
