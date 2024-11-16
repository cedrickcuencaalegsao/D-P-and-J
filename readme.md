# Distribution, Production, and Joint Ventures.

## Multi-Platform Application Project

This project integrates **Laravel**, **Flutter**, and **Next.js** frameworks to create a comprehensive application stack. Each framework serves a distinct purpose in delivering a seamless experience across web and mobile platforms while ensuring robust backend functionality.

## Project Overview

- **Backend:** Laravel powers the API and database layer, offering secure, scalable, and efficient data handling.
- **Frontend:** Next.js is used for building dynamic and server-rendered web applications.
- **Mobile App:** Flutter enables cross-platform mobile application development with a consistent user experience on both iOS and Android.

## Features

- **Laravel**

  - RESTful API implementation.
  - Authentication using Laravel Passport or Sanctum.
  - Role-based access control.
  - Eloquent ORM for database management.
  - Domain-Driven Design (DDD) for scalable architecture.

- **Next.js**

  - Server-side rendering (SSR) for faster load times.
  - Client-side routing for dynamic pages.
  - Integration with the Laravel backend for API calls.
  - Styled with Tailwind CSS and DaisyUI for a responsive UI.

- **Flutter**
  - Cross-platform support for iOS and Android.
  - State management with `flutter_bloc`.
  - Real-time API integration with Laravel backend.
  - Custom UI for consistent design and experience.

## Installation and Setup

### Make sure the following are installed on you machine:

- **Git**
- **MySql** (DataBase used)
- **XAMPP Control Panel**
- **7zip** (Optional)

### Prerequisites

- **Node.js** (for Next.js)
- **Flutter SDK**
- **PHP and Composer** (for Laravel)
- **MySQL** or your preferred database

### Backend (Laravel)

1. Clone the repository:
   ```bash
   git clone https://github.com/cedrickcuencaalegsao/D-P-and-J.git
   cd backend
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Set up your `.env` file:

   ```bash
   cp .env.example .env

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=backend
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Run the Server:
   ```bash
   php artisan serve
   ```

### Frontend (Next.js)

1. Navigate to the frontend directory:
   ```bash
   cd frontend
   ```
2. Install dependencies:
   ```bash
   npm install
   ```
3. Start the development server:
   ```bash
   npm run dev
   ```

### Mobile App (Flutter)

1. Navigate to the mobile directory:
   ```bash
   cd mobile
   ```
2. Get dependencies:
   ```bash
   flutter pub get
   ```
3. Run the app:
   ```bash
   flutter run
   ```

## Usage

- Access the web application at `http://localhost:3000` (Next.js).
- Use the mobile application on your device or emulator.
- The Laravel API will be available at `http://localhost:8000/api`.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Open a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
