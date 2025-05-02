# Laravel API Project (Dockerized) 🚀

This repository contains a Laravel-based API project running inside Docker containers. It provides user authentication, category and product management, comments, and purchase endpoints.

## Getting Started 🚀

1. Clone the repository:
   ```bash
   git clone [your-repository-url]

### Navigate to the Docker directory:
   cd docker_s          
   docker-compose up
### Run database migrations inside the php-fpm container:
      docker-compose exec php-fpm php artisan migrate


### Database credentials are configured in the .env file inside the docker_s directory.
The application runs on port 92: http://localhost:92

### Demo project in video:
https://www.youtube.com/watch?v=Fd6uP7909XM&ab_channel=Laraprojects

### Authentication 🔒
POST /api/user/register - Register a new user

POST /api/user/login - Authenticate user (get API token)

### Categories 🗂
POST /api/categories - Create category (requires auth)

GET /api/categories - List all categories

PUT /api/categories/{id} - Update category (requires auth)

DELETE /api/categories/{id} - Delete category (requires auth)

### Products 📦
POST /api/products - Create product (requires auth)

GET /api/products - List all products

PUT /api/products/{id} - Update product (requires auth)

DELETE /api/products/{id} - Delete product (requires auth)

### Comments 💬
GET /api/products/{product_id}/comments - Get product comments

POST /api/products/{product_id}/comments - Add comment (requires auth)

DELETE /api/comments/{comment_id} - Delete comment (requires auth)

Purchase 🛒
POST /api/purchase - Create purchase (requires auth)

GET /api/purchase-history - User purchase history (requires auth)
