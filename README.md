# Casino Test Application

A Laravel-based application for managing temporary links and providing a "feeling lucky" game functionality.

## Requirements

- PHP 8.2 or higher
- MySQL database
- Composer

## Tech Stack

- **Framework:** Laravel v12.0.1
- **Database:** MySQL
- **Frontend:** Tailwind CSS

### Key Dependencies

#### PHP Packages
- mockery/mockery: ^1.6.12
- guzzlehttp/guzzle: ^7.9.2
- fakerphp/faker: ^v1.24.1
- monolog/monolog: ^3.8.1
- laravel/framework: ^v12.0.1

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd casino-test-app
```

2. Create environment file:
```bash
cp .env.example .env
```

3. Start docker environment using sail :
```bash
./vendor/bin/sail up -d
```

4. Generate application key:
```bash
./vendor/bin/sail php artisan key:generate
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

6. Configure WIN_BIAS. Winning percentage, default 49% `.env`:
```env
WIN_BIAS=49
```

7. Run database migrations:
```bash
./vendor/bin/sail php artisan migrate
```

8. See registration page url: localhost

## Features

### Temporary Links System
- Generate unique temporary links
- Link activation/deactivation
- User-specific link management
- Link status tracking

### Lucky Game Feature
- Interactive "I'm Feeling Lucky" game
- User participation tracking
- Secure token-based access
