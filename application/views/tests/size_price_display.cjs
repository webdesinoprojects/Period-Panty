// Run: node application/views/tests/size_price_display.cjs
const assert = require("node:assert/strict");
const fs = require("node:fs");
const path = require("node:path");
const vm = require("node:vm");
const source = fs.readFileSync(path.resolve(__dirname, "../front/product/detail.php"), "utf8");
const start = source.indexOf("var price = $(this).data('price');");
const end = source.indexOf("\n    });", start);
assert(start >= 0 && end > start);
const handler = source.slice(start, end).replace(/<\?php echo CURRENCY_SYMBOL; \?>/g, "Rs");
for (const amount of [799.5, 0.25, 0, 999]) {
    for (const own of [0, 1]) {
        const radio = { price: amount.toFixed(2), "has-own-price": own };
        const state = {};
        const $ = selector => selector === radio ? { data: key => radio[key] } : {
            text: value => { state.display = value; },
            val: value => { state.quote = value; },
            hide: () => { state[selector] = "hidden"; },
            show: () => { state[selector] = "visible"; }
        };
        vm.runInNewContext("(function(){" + handler + "}).call(radio)", { $, radio });
        assert.equal(state.display, "Rs " + amount.toFixed(2));
        assert.equal(state.quote, amount.toFixed(2));
        assert.equal(state["#dx-price-display .text-line-through"], own ? "hidden" : "visible");
    }
}
assert(source.includes('name="quoted_price"'));
assert(source.includes("quoted_price:$('#dx-quoted-price').val()"));
console.log("PASS: decimal/zero/inherited/own prices and submitted quotes remain consistent (8 mock-DOM cases).");
