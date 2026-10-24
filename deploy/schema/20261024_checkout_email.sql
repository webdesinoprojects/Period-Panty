-- Checkout now asks for an email so the buyer gets their own order confirmation.
--
-- It is stored per order rather than on the customer record: a guest's phone is
-- unverified, so the account it happens to match may belong to somebody else and
-- must never be mailed. An address typed into a checkout is self-supplied and
-- only ever receives that same order.
--
-- Additive and re-runnable; existing rows get an empty string and simply send
-- no customer confirmation, exactly as they did before.
ALTER TABLE tbl_shipping
  ADD COLUMN IF NOT EXISTS email VARCHAR(254) NOT NULL DEFAULT '' AFTER phone;
