DEXTE catalogue corrections — 30 October 2026

Source: `updated website con2026.ods`, compared with `WEBSITE CONTENT.xlsx.ods` by embedded photographs. Row numbers below are visible spreadsheet rows, starting at 1.

The user explicitly chose the latest sheet over the previous decisions for Period Shorts, Wine and Grey. Period Shorts is now Rs. 1850. Wine and Dark Grey are Cotton, with Rs. 499 up to XL and Rs. 599 for 2XL–6XL. Existing product IDs are retained, so historical order references remain valid.

Changes:

- Cotton Black (30), Maroon (36), Wine (37) and Dark Grey (31) use the full Cotton copy from E3, with the correct colour substituted for the sheet's copied `COLOUR: Black` field. Black keeps XS according to D3; the others start at S according to their rows. All extend through 6XL. The new large-size variations use the previously authorized stock of 100; existing stock and parent product quantities are preserved. Unsupported XS variations are retained with zero available stock rather than deleted.
- Wine and Grey join Cotton and its existing swatch group. Their canonical URLs are `/cotton/cotton-period-panty-wine.html` and `/cotton/cotton-period-panty-dark-grey.html`. Their former Teen/Bamboo URLs redirect permanently, using the normal public product lookup so hidden products remain hidden.
- Period Shorts (6) and Compression-Style Period Shorts (7) use the complete E7/E8 copy, stated capacity up to 60 ml, XS–2XL, and Rs. 1850. Unsupported larger variation records remain in place with zero stock.
- The Rs. 999 Seamless range uses complete E9 copy, nylon outer/bamboo gusset specifications and stated capacity 40–50 ml. Offered sizes follow XS–3XL, except product 8, whose own row 28 explicitly allows XS–4XL. Product 28's Rs. 1850 Boyshorts is outside that Rs. 999 range and is unchanged.
- Seven missing client photos were added to the existing galleries. No current photo was deleted. Final counts: Black 8, Maroon 6, Wine 5, Grey 6. The new files are copied unchanged from the embedded source images, not generated replacements. The source supplies small images, approximately 188–280 pixels across; higher-resolution originals would improve zoom quality.
- Seamless pack-of-2 (34) uses a pink swatch (`#c96895`) to match its supplied photograph. Remaining Mid Waist wording was removed from Cotton/Bamboo descriptions and the Cotton pack-of-2. Teen colour text no longer advertises Wine as a Teen single after its approved move to Cotton.
- Existing pack prices Rs. 899 / Rs. 1350 / Rs. 1599, Teen Red Rs. 550, Teen pack-of-2 Rs. 1100, and remaining Bamboo Rs. 799 / Rs. 999 are preserved. The 13 removed products remain unavailable.
- Active admin gallery/listing/stock/image views use the same existing image resolver as the storefront, so the added media assets display in admin as well.
- The migration runner stops after a failed predecessor, checks expected targets before writing, checks key results before recording success, and handles transaction begin/commit failures. It checks matching targets rather than relying on changed-row counts, since already-correct values can legitimately affect zero rows.

Application:

`Site_refresh_model::initialize()` adds the seventh keyed migration, `20261030_sheet_catalogue_v1`, using `application/models/sql/20261030_sheet_catalogue.sql`. It follows the six existing content migrations, runs once through the existing normal request mechanism, and respects its marker thereafter. Subsequent CMS edits are not reapplied over. No manual SQL/reset step is required. Deploy the photo files with the code before serving requests. No deployment was performed in this session.

Image provenance (new sheet):

- Row 3, embedded photos 1, 3, 6: Black logo, angled and side views.
- Row 4, embedded photo 5: Maroon alternate standing pose.
- Row 5, embedded photo 4: Wine rear view.
- Row 6, embedded photos 1, 2: Grey rear and cutout views. The second cutout is a near-identical visual duplicate and was not added twice.
- One Wine photo is anchored in the Maroon row, and one Grey photo in the Wine row. Existing matching gallery photos were retained; these anchor offsets were not used to misassign a garment.

Verification performed against the running LOCAL app on `http://localhost:8082`:

- 90 assertions passed for all 27 public product identities, full copy, colour text, offered sizes and size prices, gallery counts, Cotton/Bamboo/Teen collection membership, legacy URL resolution, retained unrelated prices, all 13 removals, and stable counts after repeated entry-point requests.
- All 105 distinct gallery image URLs returned HTTP 200 with an image content type.
- 13 isolated session-cart checks passed: both cart insertion paths stored the correct Rs. 499 / Rs. 599 / Rs. 1850 prices; stale quotes and newly unsupported sizes were rejected. Test carts were emptied. No checkout order, payment, email or account was submitted.
- Existing `node application/views/tests/size_price_display.cjs` and `node application/views/tests/combo_catalogue.cjs` passed.
- `git -c core.whitespace=cr-at-eol diff --check` passed.
- Review scripts and before/after evidence are in the session's OS temporary directory `dexte-review-20261029`; the original review report is historical evidence before these fixes.

Limits: Docker control still returns a named-pipe permission denial, even though the app is running. Direct DB marker inspection, a clean replay from `/tmp/dx_pre_review.sql`, and standalone PHP CLI regression runs were not possible. Server-rendered product content was verified over HTTP; browser automation was unavailable. No orders, payments, accounts or production systems were changed by the catalogue migration.

All changes remain uncommitted. Nothing was pushed or deployed.
