# Library Management System

This project is a Library Management System built with Symfony, implementing Domain-Driven Design (DDD) and Clean Architecture principles. It was created as a collaborative effort using aider and Claude 3.5 Sonnet to test the capabilities of these AI-assisted development tools.

## Project Overview

The Library Management System allows users to manage books, authors, and borrowing records. It provides functionalities for creating, updating, and deleting books and authors, as well as managing book borrowing and returns.

## Technologies Used

- PHP 8.1+
- Symfony 6.x
- Doctrine ORM
- Twig Template Engine
- PHPUnit for testing
- Composer for dependency management

## Use Cases

1. Manage Authors
   - Create Author
   - Update Author
   - Delete Author
   - View Author

2. Manage Books
   - Create Book
   - Update Book
   - Delete Book
   - View Book

3. Manage Borrowing
   - Borrow Book
   - Return Book
   - View Borrowing Records

## How to Run the Project

Follow these steps to set up and run the project:

1. Clone the repository:
   ```
   git clone <repository-url>
   cd <project-directory>
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Set up the database:
   - Create a new database for the project
   - Update the DATABASE_URL in your .env.local file

4. Run database migrations:
   ```
   php bin/console doctrine:migrations:migrate
   ```

5. Load fixtures (optional):
   ```
   php bin/console doctrine:fixtures:load
   ```

6. Start the Symfony development server:
   ```
   symfony server:start
   ```

7. Access the application in your web browser at `http://localhost:8000`

## Running Tests

To run the test suite:

```
php bin/phpunit
```

## Additional Commands

- To clear cache:
  ```
  php bin/console cache:clear
  ```

## Project Structure

```
library-management-system/
├── bin/
│   ├── console
│   └── phpunit
├── config/
│   ├── packages/
│   ├── routes/
│   ├── bundles.php
│   ├── preload.php
│   ├── routes.yaml
│   └── services.yaml
├── migrations/
├── public/
│   └── index.php
├── src/
│   ├── Application/
│   │   └── UseCase/
│   ├── Domain/
│   │   ├── Entity/
│   │   └── Repository/
│   ├── Infrastructure/
│   │   ├── Framework/
│   │   │   ├── Controller/
│   │   │   ├── Form/
│   │   │   └── Twig/
│   │   ├── Persistence/
│   │   │   └── Doctrine/
│   │   └── Security/
│   └── Kernel.php
├── templates/
│   ├── author/
│   ├── book/
│   ├── borrow/
│   ├── components/
│   ├── home/
│   ├── security/
│   └── base.html.twig
├── tests/
├── translations/
├── .env
├── .env.local
├── .gitignore
├── composer.json
├── composer.lock
├── phpunit.xml.dist
└── README.md
```

This structure reflects the Domain-Driven Design and Clean Architecture principles used in the project.
