-- Columns the Razorpay flow needs are added by the runner (DDL cannot sit in
-- the transaction). This file backfills what the new columns should say about
-- orders that already exist.
--
-- amount_paise is the figure every later check compares against, so it is
-- derived once from final_amount rather than recomputed per request.

UPDATE tbl_order SET amount_paise = ROUND(final_amount * 100)
WHERE amount_paise = 0 AND final_amount > 0;

-- Orders already paid online keep their gateway reference in transaction_no;
-- carry it across so the new column is not misleadingly empty for them.
UPDATE tbl_order SET razorpay_payment_id = transaction_no
WHERE razorpay_payment_id = '' AND payment_status = 'Paid'
  AND payment_method = 'Pay Online' AND transaction_no LIKE 'pay\_%';
