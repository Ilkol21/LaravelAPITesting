
Laravel API Project (Dockerized) 🚀
This repository contains a Laravel-based API project running inside Docker containers. It provides user authentication, category and product management, comments, and purchase endpoints. The database credentials are configured in the .env file located inside the docker_s directory.
Getting Started 🚀
Follow these steps to get the project running locally:
Clone the repository:
bash
git clone <repository-url>
Navigate to the Docker directory:
bash
cd docker_s
Start the Docker containers:
bash
docker-compose up
Run database migrations inside the php-fpm container:
bash
docker-compose exec php-fpm php artisan migrate
Database credentials are defined in the .env file inside the docker_s directory.
The application runs on port 92, so it can be accessed at http://localhost:92.
Authentication 🔒
POST /api/user/register — Register a new user.
POST /api/user/login — Authenticate a user and obtain an API token.
Categories 🗂
POST /api/categories — Create a new category (requires authorization).
GET /api/categories — Retrieve a list of all categories.
PUT /api/categories/{id} — Update an existing category by its ID (requires authorization).
DELETE /api/categories/{id} — Delete a category by its ID (requires authorization).
Products 📦
POST /api/products — Create a new product (requires authorization).
GET /api/products — Retrieve a list of all products.
PUT /api/products/{id} — Update an existing product by its ID (requires authorization).
DELETE /api/products/{id} — Delete a product by its ID (requires authorization).
Comments 💬
GET /api/products/{product_id}/comments — Retrieve all comments for a specific product.
POST /api/products/{product_id}/comments — Add a new comment to a product (requires authorization).
DELETE /api/comments/{comment_id} — Delete a comment by its ID (requires authorization).
Purchase 🛒
POST /api/purchase — Create a new purchase record (requires authorization).
GET /api/purchase-history — Retrieve the purchase history of the authenticated user (requires authorization).
