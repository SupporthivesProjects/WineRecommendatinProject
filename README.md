# Wine Recommender

A sophisticated web application that helps users discover their perfect wine match based on taste preferences and food pairings.

## Overview

Wine Recommender is a Laravel-based application that uses intelligent recommendation algorithms to suggest wines based on user preferences. The application features a beautiful UI, user authentication, and a comprehensive wine database.

![Wine Recommender Screenshot](https://example.com/screenshot.png)

## Features

- Personalized wine recommendations
- Food and wine pairing suggestions
- User authentication and profiles
- Comprehensive wine catalog
- Mobile-responsive design
- Wine region and grape variety information

## Requirements

- PHP >= 8.1
- Composer
- MySQL or MariaDB
- Node.js & NPM (for frontend assets)
- Git

## Installation

Follow these steps to set up the Wine Recommender project on your local machine:

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/wine-recommender.git
cd wine-recommender
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create and configure environment file

```bash
cp .env.example .env
```

Edit the `.env` file and update the database configuration:

```
APP_NAME="Wine Recommender"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wine_recommender
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Create the database

Create a new MySQL database named `wine_recommender` (or whatever you specified in your `.env` file).

```bash
mysql -u root -p
```

```sql
CREATE DATABASE wine_recommender;
EXIT;
```

### 6. Run database migrations

```bash
php artisan migrate
```

### 7. Seed the database (optional)

If you want to populate the database with sample data:

```bash
php artisan db:seed
```

### 8. Install frontend dependencies

```bash
npm install
```

### 9. Build frontend assets

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 10. Start the development server

```bash
php artisan serve
```

The application will be available at http://localhost:8000

## Project Structure

- `app/` - Contains the core code of the application
- `config/` - Contains all configuration files
- `database/` - Contains database migrations and seeders
- `public/` - Contains publicly accessible files
- `resources/` - Contains views, raw assets, and language files
- `routes/` - Contains all route definitions
- `storage/` - Contains compiled Blade templates, file-based sessions, caches
- `tests/` - Contains test cases

## Database Schema

The application uses the following main tables:

- `users` - Stores user information
- `wines` - Stores wine information
- `wine_types` - Stores wine type categories
- `regions` - Stores wine region information
- `grape_varieties` - Stores grape variety information
- `food_pairings` - Stores food pairing suggestions
- `user_preferences` - Stores user taste preferences
- `ratings` - Stores user ratings for wines

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

This project follows the PSR-12 coding standard. You can check your code style with:

```bash
./vendor/bin/phpcs
```

### Frontend Development

The project uses Tailwind CSS for styling. To watch for changes in the frontend assets:

```bash
npm run watch
```

## Deployment

For deployment to production, follow these additional steps:

1. Set `APP_ENV=production` and `APP_DEBUG=false` in your `.env` file
2. Optimize the application:

```bash
php artisan optimize
php artisan route:cache
php artisan config:cache
php artisan view:cache
```

3. Build production assets:

```bash
npm run build
```

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Commit your changes: `git commit -m 'Add some feature'`
4. Push to the branch: `git push origin feature-name`
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements

- [Laravel](https://laravel.com) - The web framework used
- [Tailwind CSS](https://tailwindcss.com) - For styling
- [Unsplash](https://unsplash.com) - For wine images

## Contact

For questions or support, please contact us at info@winerecommender.com.

---

Happy wine discovering! 🍷