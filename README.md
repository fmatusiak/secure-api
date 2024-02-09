# Secure Check API

Secure Check API is a simple system for security checks management.

## Introduction

Secure Check API is a tool designed to monitor and manage security checks in various environments.

## Requirements

- PHP >= 8.1
- Laravel >= 10
- MySQL or any other database supported by Laravel

## Installation

1. Clone the repository:


    git clone <repository_address>

2. Navigate to the project directory:


    cd secure-check-app

3. Install PHP dependencies using Composer:


    composer install


4. Copy the `.env.example` file to `.env` and configure the database connection.

5. Generate the application key:

    
    php artisan key:generate


6. Run migrations to create necessary tables in the database:


    php artisan migrate



7. Optionally, seed the database with sample data:
   
    
    php artisan db:seed
















