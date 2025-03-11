# Executive Voting App

A real-time electronic voting system built with Laravel, HTMX, and FilamentPHP. This application enables transparent, fair, and inclusive election processes for executive member positions.

## Project Overview

This application facilitates anonymous electronic voting for executive positions within the organization. It allows for real-time result tracking, ensures one-person-one-vote procedures, and maintains transparency throughout the election process.

### Key Features

**Administrative Dashboard**   
Built with FilamentPHP for easy management of elections, positions, organizations, and representatives

**Real-time Results**  
Live updating vote counts using HTMX

**Anonymous Voting**  
Secure voting system that maintains voter anonymity

**Voter Verification**  
Simple voter identification using predefined voter IDs

**Public Results Page**  
Real-time results displayed on a public-facing page without authentication

**Audit Trail**  
Transparent vote counting and results declaration

## Tech Stack

**Backend**  
Laravel 12

**Frontend**  
HTMX with Alpine.js

**Admin Panel**  
FilamentPHP 3.2


**Database**  
MySQL/PostgreSQL


## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL
- Git

### Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/yethihahtwe/Executive-Voting.git executive-voting
   cd executive-voting
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create a copy of the `.env.example` file:
   ```bash
   cp .env.example .env
   ```

5. Configure your database connection in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=voting_app
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Generate an application key:
   ```bash
   php artisan key:generate
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

8. Build frontend assets:
   ```bash
   npm run dev
   ```

9. Start the development server:
    ```bash
    php artisan serve
    ```

10. Access the application:
    - Main application: http://localhost:8000
    - Admin panel: http://localhost:8000/admin

## Application Structure

### Database Schema

The application uses the following database structure

erDiagram
    ORGANIZATION {
        int id PK
        string name
        string abbreviation
        timestamp created_at
        timestamp updated_at
    }
    
    ADMIN_USER {
        int id PK
        string name
        string email
        string password
        timestamp created_at
        timestamp updated_at
    }
    
    REPRESENTATIVE {
        int id PK
        int organization_id FK
        string name
        string position
        boolean is_elected
        timestamp created_at
        timestamp updated_at
    }
    
    ELECTION {
        int id PK
        string title
        text description
        datetime start_date
        datetime end_date
        boolean is_active
        boolean completed
        string status
        timestamp created_at
        timestamp updated_at
    }
    
    POSITION {
        int id PK
        string title
        string description
        int election_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    VOTER {
        int id PK
        string voter_id
        int organization_id FK
        int election_id FK
        boolean has_voted
        timestamp voted_at
        timestamp created_at
        timestamp updated_at
    }
    
    VOTE {
        int id PK
        int voter_id FK
        int representative_id FK
        int position_id FK
        int election_id FK
        timestamp created_at
    }
    
    ORGANIZATION ||--o{ REPRESENTATIVE : "has"
    ORGANIZATION ||--o{ VOTER : "belongs to"
    ELECTION ||--o{ POSITION : "has"
    REPRESENTATIVE ||--o{ VOTE : "receives"
    POSITION ||--o{ VOTE : "relates to"
    ELECTION ||--o{ VOTE : "contains"
    VOTER ||--o{ VOTE : "casts"
    ELECTION ||--o{ VOTER : "participates in"

**Organizations**  
Core member organizations eligible for representation

**Representatives**  
Members from organizations who can be nominated for positions

**Elections**  
Individual election events with specific start and end dates

**Positions**  
Executive positions available in each election (e.g. Chairperson, Vice Chairperson, Secretary, Joint Secretary, Treasurer, etc)

**Voters**  
Organization representatives with voting rights

**Votes**  
Anonymous vote records

### User Roles

**Admin**  
Manages the entire election process through the FilamentPHP dashboard

**Voters**  
Verified with voter IDs to cast votes

**Public**  
Can view real-time election results without authentication

## Election Process

1. Admin creates an election with specified dates
2. Organizations and their representatives are registered
3. Positions are defined for the election
4. Voter IDs are generated and distributed
5. Voting occurs during the election period
6. Results are tabulated and displayed in real-time
7. Final results are officially declared when the election ends

## Development

### Key Components

**FilamentPHP Resources**  
Located in `app/Filament/Resources/`

**Models**  
Located in `app/Models/`

**Controllers**  
Located in `app/Http/Controllers/`

**Views**  
Located in `resources/views/`

**HTMX Components**  
Located in `resources/views/components/`


## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements

- [Laravel](https://laravel.com)
- [FilamentPHP](https://filamentphp.com)
- [HTMX](https://htmx.org)
