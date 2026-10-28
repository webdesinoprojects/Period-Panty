# Contextual lifestyle images — 28 October

Generated using the built-in image-generation tool; no API/CLI fallback. The previous underwear photos are replaced only in the seven “Made for different needs” cards. Labels, descriptions, links, ordering and layout remain unchanged, and slider images remain editable in admin.

The generated originals remain in the image-generation cache. Final web assets are encoded at 512×512 JPEG quality 88 to keep these small cards lightweight. Visual review of the website is left to the user as requested.

## Saved assets and prompts

### Teenagers

`assets/front/media/dx-needs-teen-v2.jpg`

Use case: photorealistic-natural. One square lifestyle photograph, 1024 by 1024. A 19-year-old adult Indian university student in a pastel sage button-up shirt and casual loose trousers, holding notebooks at chest level with a canvas backpack over one shoulder on a bright leafy campus. Friendly candid smile, ordinary academic day, fully clothed. Portrait framing from the waist up with the face, notebooks and backpack comfortably inside the central 70 percent. Warm soft natural daylight, cream and sage palette, softly blurred trees and university walkway. Tasteful editorial photography, realistic skin texture. No text, watermarks, graphic elements or commercial product props.

### Working Women

`assets/front/media/dx-needs-work-v2.jpg`

Use case: photorealistic-natural. Asset: one square 1024x1024 lifestyle photo for a small circular-corner website category card on an Indian women's wellness brand. Warm natural daylight, elegant editorial photography, cream and sage colour palette, believable skin texture, gentle candid confidence, uncluttered softly blurred background. Keep face and relevant activity comfortably inside the central 70 percent so a square crop works at 170px. No text, logos, borders, collage or watermark. Fully clothed, modest everyday styling. Do not show underwear, product packaging, intimate areas or sexual poses. A confident adult Indian professional woman around 32 wearing a tailored warm beige business suit jacket over an opaque ivory blouse, seated at a bright modern office desk working on a laptop. A little green plant in the softly blurred background. Frame waist-up with face and laptop visible.

### Post Delivery

`assets/front/media/dx-needs-postdelivery-v2.jpg`

Use case: photorealistic-natural. Asset: one square 1024x1024 lifestyle photo for a small circular-corner website category card on an Indian women's wellness brand. Warm natural daylight, elegant editorial photography, cream and sage colour palette, believable skin texture, gentle candid confidence, uncluttered softly blurred background. Keep face and relevant activity comfortably inside the central 70 percent so a square crop works at 170px. No text, logos, borders, collage or watermark. Fully clothed, modest everyday styling. Do not show underwear, product packaging, intimate areas or sexual poses. A calm adult Indian new mother around 29 wearing a loose opaque long-sleeved cream blouse, seated in a cosy sunlit nursery gently holding her fully clothed, wrapped newborn baby close to her shoulder. Tender smile, natural affectionate moment. Portrait from waist up. No breastfeeding, no exposed chest.

### Spotting

`assets/front/media/dx-needs-spotting-v2.jpg`

Use case: photorealistic-natural. Asset: one square 1024x1024 lifestyle photo for a small circular-corner website category card on an Indian women's wellness brand. Warm natural daylight, elegant editorial photography, cream and sage colour palette, believable skin texture, gentle candid confidence, uncluttered softly blurred background. Keep face and relevant activity comfortably inside the central 70 percent so a square crop works at 170px. No text, logos, borders, collage or watermark. Fully clothed, modest everyday styling. Do not show underwear, product packaging, intimate areas or sexual poses. An adult Indian woman around 26 in a modest soft blush-pink long-sleeved shirt and comfortable loose trousers relaxing on a cream sofa, holding a journal and smiling gently during a peaceful ordinary morning. Bright airy room, small vase of greenery blurred behind. Upper-body framing, a relaxed everyday comfort scene, no medical visual or pain pose.

### Menopause

`assets/front/media/dx-needs-menopause-v2.jpg`

Use case: photorealistic-natural. Asset: one square 1024x1024 lifestyle photo for a small circular-corner website category card on an Indian women's wellness brand. Warm natural daylight, elegant editorial photography, cream and sage colour palette, believable skin texture, gentle candid confidence, uncluttered softly blurred background. Keep face and relevant activity comfortably inside the central 70 percent so a square crop works at 170px. No text, logos, borders, collage or watermark. Fully clothed, modest everyday styling. Do not show underwear, product packaging, intimate areas or sexual poses. An elegant mature Indian woman around 53 with some natural silver strands in her dark hair, wearing an opaque sage-green kurta, enjoying a cup of tea beside a sunny window at home. Warm confident relaxed smile. Waist-up portrait with face and cup centred, graceful and positive mature adulthood.

### Urine Incontinence

`assets/front/media/dx-needs-bladder-v2.jpg`

Use case: photorealistic-natural. Asset: one square 1024x1024 lifestyle photo for a small circular-corner website category card on an Indian women's wellness brand. Warm natural daylight, elegant editorial photography, cream and sage colour palette, believable skin texture, gentle candid confidence, uncluttered softly blurred background. Keep face and relevant activity comfortably inside the central 70 percent so a square crop works at 170px. No text, logos, borders, collage or watermark. Fully clothed, modest everyday styling. Do not show underwear, product packaging, intimate areas or sexual poses. An active older Indian woman around 65 with softly grey hair, fully clothed in a light ivory tunic over comfortable trousers and a sage cardigan, walking confidently in a green garden on a gentle morning stroll. Friendly natural smile, upright posture, waist-up framing with a little garden path visible behind. Dignified active independence, no medical devices, no bathroom imagery, no embarrassing or shameful depiction.

### Sports & Activities

`assets/front/media/dx-needs-sports-v2.jpg`

Use case: photorealistic-natural. Asset: one square 1024x1024 lifestyle photo for a small circular-corner website category card on an Indian women's wellness brand. Warm natural daylight, elegant editorial photography, cream and sage colour palette, believable skin texture, gentle candid confidence, uncluttered softly blurred background. Keep face and relevant activity comfortably inside the central 70 percent so a square crop works at 170px. No text, logos, borders, collage or watermark. Fully clothed, modest everyday styling. Do not show underwear, product packaging, intimate areas or sexual poses. An athletic adult Indian woman around 28 in an opaque sage athletic T-shirt covering the waist and dark full-length leggings, outdoors on a park jogging trail, in a natural light jogging pose. Happy and energetic, ponytail, face and upper body visible with bent arms. Modest sportswear, no crop top or exposed midriff, no gym branding.

## Rollout and verification

`Site_refresh_model` applies `20261028_needs_lifestyle_v1` independently of the earlier collections/contact migration, using `application/models/sql/20261028_needs_lifestyle.sql`. It changes only `tbl_slider.image` for the seven matching Footer cards and records its own marker; subsequent CMS edits are preserved. Existing product photos/files remain available elsewhere; they are not deleted.

Run `node application/views/tests/needs_lifestyle.cjs`. This checks seven unique generated image files, all card mappings, migration scoping and independent migration guards. The previous bulk-order and size-price JavaScript regressions are also retained. No commit, push, deployment or live database execution is performed for this change.
