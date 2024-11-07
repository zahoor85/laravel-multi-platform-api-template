## About This Project

This is a Laravel 10 REST API boilerplate designed for both web and mobile applications, using **Sanctum** for secure token-based authentication. It includes Laravel Breeze for easy authentication management and has been customized to support frontend URLs for email verification and password reset, allowing for separate frontend and backend URLs.

### Features

- **Token-based Authentication**: Secure token authentication with Laravel Sanctum.
- **Frontend URL Customization**: Supports frontend URLs for email verification and password reset.
- **Multi-platform Support**: Designed to work seamlessly with both web and mobile applications.


## Getting Started

### Requirements

- **PHP**: 8.1 or higher
- **Composer**: 2.0 or higher
- **Laravel**: 10
- **Database**: MySQL or other compatible database

### Configuration

1. **Setup:**:
   ```bash
      composer install
      npm install
      cp .env.example  .env
      

2. **Environment Variables:**:
    Add your frontend URL in the .env file:
   ```bash
   FRONTEND_URL=http://your-frontend-domain.com


3. **Headers Requirement**:
   For REST clients, it is **mandatory** to pass the following headers to properly interact with the API and avoid hitting the default web routes (`web.php`):
   ```bash
   Content-Type: application/json
   Accept: application/json
      


This format includes the project logo, badges, a detailed description, and essential setup instructions. It also clearly lists the headers requirement for REST API clients. Let me know if there’s anything more you’d like to add!


         
