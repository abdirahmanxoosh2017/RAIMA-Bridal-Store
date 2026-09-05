USE raima_bridal_store;

INSERT INTO roles (name, description) VALUES
('admin', 'Full store administration access'),
('customer', 'Customer storefront access')
ON DUPLICATE KEY UPDATE description = VALUES(description);

INSERT INTO permissions (name, description) VALUES
('dashboard.view', 'View admin dashboard'),
('products.manage', 'Create, read, update and delete products'),
('categories.manage', 'Manage product categories'),
('orders.manage', 'Manage customer orders'),
('bookings.manage', 'Manage wedding bookings'),
('customers.manage', 'Manage customer accounts'),
('payments.manage', 'Manage payment records'),
('reviews.manage', 'Moderate reviews'),
('coupons.manage', 'Manage coupons and discounts'),
('users.manage', 'Manage admin users'),
('roles.manage', 'Manage roles and permissions'),
('cms.manage', 'Manage pages and banners'),
('reports.view', 'View reports'),
('settings.manage', 'Manage application settings'),
('activity_logs.view', 'View activity logs')
ON DUPLICATE KEY UPDATE description = VALUES(description);

INSERT IGNORE INTO role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM roles r CROSS JOIN permissions p
WHERE r.name = 'admin';

INSERT INTO categories (name, slug, description, status) VALUES
('Wedding Dresses', 'wedding-dresses', 'Bridal wedding dress collection', 'active'),
('Evening Dresses', 'evening-dresses', 'Elegant evening collection', 'active'),
('Accessories', 'accessories', 'Bridal accessories and finishing touches', 'active'),
('Wedding Services', 'wedding-services', 'Wedding planning and event services', 'active')
ON DUPLICATE KEY UPDATE description = VALUES(description), status = VALUES(status);

INSERT INTO products (category_id, type, name, slug, sku, description, price, stock_qty, status, featured)
SELECT c.id, 'dress', 'Royal Princess Gown', 'royal-princess-gown', 'DRESS-001', 'Elegant princess bridal gown for the modern bride.', 1250.00, 5, 'active', 1
FROM categories c WHERE c.slug = 'wedding-dresses'
ON DUPLICATE KEY UPDATE description = VALUES(description), price = VALUES(price), stock_qty = VALUES(stock_qty), status = VALUES(status), featured = VALUES(featured);

INSERT INTO products (category_id, type, name, slug, sku, description, price, stock_qty, status, featured)
SELECT c.id, 'dress', 'Bridal Mermaid Gown', 'bridal-mermaid-gown', 'DRESS-002', 'Contemporary mermaid silhouette with refined detailing.', 980.00, 4, 'active', 1
FROM categories c WHERE c.slug = 'wedding-dresses'
ON DUPLICATE KEY UPDATE description = VALUES(description), price = VALUES(price), stock_qty = VALUES(stock_qty), status = VALUES(status), featured = VALUES(featured);

INSERT INTO products (category_id, type, name, slug, sku, description, price, stock_qty, status, featured)
SELECT c.id, 'accessory', 'Pearl Bridal Veil', 'pearl-bridal-veil', 'ACC-001', 'Soft bridal veil finished with pearl accents.', 180.00, 10, 'active', 1
FROM categories c WHERE c.slug = 'accessories'
ON DUPLICATE KEY UPDATE description = VALUES(description), price = VALUES(price), stock_qty = VALUES(stock_qty), status = VALUES(status), featured = VALUES(featured);

INSERT INTO cms_pages (title, slug, content, status) VALUES
('About RAIMA', 'about', '<h2>Elegance for Your Special Day</h2><p>RAIMA Bridal Store brings bridal fashion and wedding planning together in one refined experience.</p>', 'published'),
('Privacy Policy', 'privacy-policy', '<h2>Privacy Policy</h2><p>Your customer information is handled responsibly and used only to provide the requested services.</p>', 'published'),
('Terms & Conditions', 'terms', '<h2>Terms & Conditions</h2><p>Store terms, booking conditions and service policies are published here.</p>', 'published')
ON DUPLICATE KEY UPDATE content = VALUES(content), status = VALUES(status);
