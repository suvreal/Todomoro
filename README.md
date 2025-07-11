# 🎯 Todomoro

- a simple TODO application written in Laravel, Vue and Tailwind

## 🗂️ Table of Contents

- [🎯 Todomoro](#-todomoro)
- [🗂️ Table of Contents](#-table-of-contents)
- [🌟 Features](#-features)
- [⚙️ Project Setup](#-project-setup)
    - [🖥️ System Requirements](#-system-requirements)
    - [🕵️‍♂️ System Check](#-system-check)
    - [🛠️ One-time System Setup](#-one-time-system-setup)
    - [📦 Npm and Node update](#-npm-and-node-update)
- [🏃‍♂️ How to run](#-how-to-run)
    - [📋 Makefile](#-makefile)
    - [🧩 Manually](#-manually)
- [🌐 Usage](#-usage)
- [✅ Code Quality & Static Analysis](#-code-quality--static-analysis)
- [🧪 Running Tests](#-running-tests)
- [🚀 Potential Future Enhancements](#-potential-future-enhancements)

## 🌟 Features

- Full Task CRUD (Create, Read, Update, Delete)
- Task search and filter system (status, deadline, query input)
- Parent-child task relationships (subtasks)
- Status and deadline management
- Responsive, mobile-friendly UI with Tailwind CSS
- Animated gradient background effect using custom CSS
- Modern button styles: transparent border with hover-fill behavior
- Icons for task actions (Edit, Show, Delete) using Font Awesome
- Fallback route redirect to the task list if a page is not found
- Basic automated tests for PHP and Vue components

## ⚙️ Project Setup

### 🖥️ System Requirements

* PHP 8.2 or 8.3
* Composer 2.x+
* Node.js 18.x+
* npm 9.x or 10.x (tested on: 10.8.2)
* Node 18.x + (tested on: v20.19.3)
* Laravel CLI (optional)

#### 🕵️‍♂️ System Check

- System setup
    - Check your NPM and NODE Versions by [System Requirements](#-system-requirements):
        - follow these steps if needed [Npm & Node update](#-npm-and-node-update)
    - Check [Watchers System Setup](#-one-time-system-setup)
    - Check permissions for the project directory:
        - in the project directory of **Todomoro** run the following (or `make fix-permission`):
      ```bash
      sudo chown -R user:user_group .
      sudo chown -R $$(id -u):www-data storage bootstrap/cache
      sudo chmod -R 775 storage bootstrap/cache
      ```

#### 🛠️ One-time System Setup:

- Increase system file watcher limits (required for Vite on Linux):
  ```bash
  make watcher-check
  ```

#### 📦 Npm and Node update

- If needed, then follow these steps to update Node and NPM (Linux):
    1. `curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash`
    2. `source ~/.bashrc  # or ~/.zshrc or ~/.profile`
    3. `nvm install 20`
    4. `nvm use 20`
    5. `nvm alias default 20`
    6. `rm -rf node_modules package-lock.json`

## 🏃‍♂️ How to run

- Clone repository:
  ```bash
  git clone https://github.com/yourusername/todomoro-app.git
  ```
- Move to the directory:
  ```bash
  cd Todomoro
  ```
- Then chose the startup method the chapters below

### 📋 Makefile

  ```bash
    make dev
  ```

### 🧩 Manually

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install Node.js dependencies:

   ```bash
   npm install
   ```

3. Check up already prepared `.env` file and configure your database connection:
   ```bash
   cp .env.example .env
   ```

4. Run migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

    - Option choice - **YES** - create DB to perform seeds

5. Compile assets and start development servers:

    * Laravel - one CLI:

      ```bash
      php artisan serve
      ```

    * Vite - second CLI:

      ```bash
      npm run dev
      ```

## 🌐 Usage

- Access the app at: [Todomoro Tasks](http://localhost:8000/tasks)

## ✅ Code Quality & Static Analysis

- PHPStan (Static Analysis):

  ```bash
  composer analyse
  ```

- Laravel Pint (Code Style):

  ```bash
  composer format
  ```

- Laravel Insights (Code Smell & Complexity):

  ```bash
  composer quality
  ```

## 🧪 Running Tests

- PHP Feature & Unit Tests:
    - Ensure your project is run:
      ```bash
      make run
      ```
    - then run:
      ```bash
      php artisan test
      ```

- Vue Component Unit Tests (Vitest):

  ```bash
  npm run test:unit
  ```

# 🚀 Potential Future Enhancements

- Full-fledged production implementation
- Authentication
- Dashboard
- Task priorities and notifications
- Dark mode toggle
- User data exports in JSON
- Multi-language support
- Taxonomy
- Relationships
- Content groups & user sharing
