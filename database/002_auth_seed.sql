USE raima_bridal_store;

-- Generate a real password hash with PHP password_hash() before production use.
-- Demo password placeholder is intentionally not stored as plaintext.
-- Example: INSERT INTO users (..., password_hash) VALUES (..., '$2y$10$...');

INSERT IGNORE INTO users (role_id,name,email,password_hash,phone,status)
VALUES (2,'Demo Customer','customer@example.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llCkF9L3QZ7u4u7y5u5yO','+252000000000','active');
