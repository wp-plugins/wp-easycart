;
ALTER TABLE ec_user ADD `realauth_registered` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, customer is using Realex Payments and this customer already has an account in the RealVault.';