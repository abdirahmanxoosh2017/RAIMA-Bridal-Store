# Database

The canonical MySQL schema and seed data will live in this directory.

Planned schema groups:

- Authentication: users, roles, permissions, role_permissions
- Catalog: categories, products, product_images, services
- Commerce: carts, cart_items, orders, order_items, payments, coupons, coupon_usages
- Customer: addresses, wishlists, wishlist_items, notifications
- Planning: bookings, wedding_plans, wedding_plan_items
- Content: pages, banners, newsletter_subscribers, faqs, contacts
- Quality/audit: reviews, activity_logs, settings

All database access will use PDO prepared statements and foreign-key constraints.
