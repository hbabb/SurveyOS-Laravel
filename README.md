# ![SurveyOS Logo](docs/images/surveyos-logo.png)

# SurveyOS

**Land Survey Project Management & CAD Integration Platform**  
*Built for GeoNexa*

[![Laravel](https://img.shields.io/badge/Laravel-13.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16+-336791.svg)](https://www.postgresql.org)
[![Docker](https://img.shields.io/badge/Docker-Sail-2496ED.svg)](https://laravel.com/docs/sail)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

---

## About

SurveyOS is a modern land survey project management system designed to support the full workflow of a land surveying company — from initial lead intake through research, field work, drafting, review, and final delivery.

This V1 is being developed in **Laravel 13** with **PostgreSQL** and uses **Laravel Sail** for a consistent, isolated development environment.

The system is being built by **TechSolvd** for **GeoNexa**.

## Vision

Enable small to mid-sized land survey companies to manage complex projects with reliable data flow between office and CAD tools while building a scalable foundation for future GIS capabilities and productization.

## Key Features

- End-to-end project lifecycle management
- Research document organization and client access
- Time tracking and scheduling
- Client portal for transparency
- CAD data synchronization (in development)
- Scalable foundation for future productization

## Tech Stack

- **Backend**: Laravel 13
- **Database**: PostgreSQL 16+
- **Development Environment**: Laravel Sail (Docker)
- **Current Frontend**: Blade
- **IDE**: PHPStorm

## Getting Started

### Prerequisites

- Docker & Docker Compose
- Git
- PHP 8.5+ (Mise recommended for version management)

### Installation

```bash
# Clone the repository
git clone <repository-url>
cd your-project-name

# Start the development environment
./vendor/bin/sail up -d

# Run database migrations
./vendor/bin/sail artisan migrate
```

The application will be available at `http://localhost`.

## Documentation

- [V1 Plan](docs/V1_PLAN.md)
- [User Stories](docs/UserStories.md)
- [ERD](docs/ERD.md)
- [API Inventory](docs/API_INVENTORY.md)

## Contributing

This project is currently in active development. Collaboration is welcome through documentation and Markdown-based discussions.

## License

This project is proprietary.

---

**Developed by Heath**  
![TechSolvd Logo](docs/images/techsolvd-logo-small.png)  
[TechSolvd](https://techsolvd.com) • [@techsolvd](https://x.com/techsolvd)
