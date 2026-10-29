const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const repo = path.resolve(__dirname, '../../..');
const sql = fs.readFileSync(path.join(repo, 'application/models/sql/20261028_needs_lifestyle.sql'), 'utf8');
const assignments = [...sql.matchAll(/UPDATE tbl_slider SET image = '([^']+)' WHERE type = 'Footer' AND title = '([^']+)';/g)];
assert.equal(assignments.length, 7, 'Each needs card must have one lifestyle image.');
assert.equal(new Set(assignments.map(x => x[1])).size, 7, 'Do not reuse the same image across cards.');
assert.deepEqual(assignments.map(x => x[2]), ['Teenagers', 'Working Women', 'Post Delivery', 'Spotting', 'Menopause', 'Urine Incontinence', 'Sports & Activities']);
for (const [, file] of assignments) {
    const bytes = fs.readFileSync(path.join(repo, 'assets/front/media', file));
    assert(bytes.length > 10000, 'Image must not be a placeholder: ' + file);
    assert.equal(bytes.readUInt16BE(0), 0xffd8, 'Expected a JPEG web asset.');
    assert(bytes.length < 300000, 'Thumbnail should stay lightweight: ' + file);
}
assert(!/\b(?:DELETE|INSERT|ALTER|DROP)\b/i.test(sql), 'Image update must not delete content or alter schema.');
assert(!/SET\s+(?:title|description|button_link|price|qty)\s*=/i.test(sql), 'Preserve card copy/links and product data.');
const runner = fs.readFileSync(path.join(repo, 'application/models/Site_refresh_model.php'), 'utf8');
assert(runner.includes("'20261028_needs_lifestyle_v1' => '20261028_needs_lifestyle.sql'"), 'Migration must stay registered in the runner.');
assert(runner.includes('$done[$key]'), 'Migration completion must be tracked independently per migration.');
const home = fs.readFileSync(path.join(repo, 'application/views/front/home.php'), 'utf8');
assert(home.includes("content_image('slider', $dx_m->image)"), 'Cards must serve the new assets and still honour CMS images.');
console.log('PASS: seven distinct lifestyle images, scoped CMS migration, unchanged copy/links and per-migration guards.');
