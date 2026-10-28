# 28 October storefront update

No commit, push or deployment performed by Codex.

## Scope

- Replace High Waist / Mid Waist / Shorts navigation and home cards with Bamboo, Seamless and Cotton; keep Combo and Teen available.
- Move non-deleted products whose **base product price** is 999 into Seamless. Bamboo sizes priced 999 remain Bamboo, because their parent price is 799. No prices, stock, users or orders are changed.
- Use the supplied pink boxed pack for Combo, including Most Loved; add gold DEXTE branding to both editorial photos; remove Latest Collection's starting-price description.
- Update contact settings, WhatsApp, invoice/registered address and map to the supplied phone/emails and Gurgaon. Preserve the configured outbound From address so existing verified-domain email delivery is not broken.
- Dedicated `/bulk-orders` quotation form: name, organisation, phone, optional email, category, quantity, sizes, colours, city, PIN, address, requested date and notes. Save into the existing admin enquiries inbox (`admin/user/all_mail`) **before** attempting notifications to both contact emails. A quote request never creates an order or starts payment.

## Data/schema rollout

`Category_model` loads `Site_refresh_model` on application startup. It uses a named lock, creates its own migration-marker table and adds `tbl_setting.email_secondary` if absent. Schema changes happen **before** the content transaction. It then applies `application/models/sql/20261028_collections_contact.sql` once and records `20261028_collections_contact_v1`. Later CMS changes are not overwritten. This content SQL is owned by that runner: do not execute it separately without the schema setup/marker.

Upload all changed files, including `application/models/sql/` and `assets/front/media/`. The assets are served from the versioned media directory, so local uploads mounts do not need replacing. Existing category URLs remain readable; new links use `/bamboo.html`, `/seamless.html`, `/cotton.html` and `/combo.html`.

Secondary email and LinkedIn are editable in Settings; collection flags, copy and imagery remain category/slider CMS data. The address is city-level because no new street address was supplied.

## Checks

Passed: `node application/views/tests/bulk_order_ui.cjs`, `node application/views/tests/size_price_display.cjs` (8 price cases), JavaScript syntax check, and whitespace checks. The new tests cover client-side required-size handling, submit behaviour, image references, migration scope, category URL guards and container/stylesheet balance.

Still to run: `php application/views/tests/bulk_order_regression.php`. The PHP fixtures do not send email or access the database. This session has no PHP CLI; Docker's control pipe is permission-denied, the in-app browser is unavailable, and neither localhost nor 127.0.0.1:8082 was reachable. Therefore no successful live form submission, migration execution or email delivery is claimed. With the app reachable, check initial and paginated category grids, sort/filter/clear, the bulk form's validation and saved admin enquiry, secondary contact details and the map query. Real email delivery depends on the existing Resend/SMTP configuration. Visual review is left to the user as requested.

## Generated assets

Built-in image generation was used, not the API/CLI fallback. Outputs:

- `assets/front/media/dx-collection-branded-v2.jpg`
- `assets/front/media/dx-about-branded-v2.jpg`

Prompts: preserve the existing cream-linen flat-lay photographs and their blank left sides, add small gold embroidered uppercase `DEXTE` branding at the upper-right hip of each garment using the supplied pack as reference, and add no headline, price, caption or button. The collection scene retains maroon/green/black panties; the about scene retains the maroon panty on folded fabrics, spool and eucalyptus. Page copy remains HTML/CMS text rather than being baked into the photographs.
