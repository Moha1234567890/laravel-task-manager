# Laravel Task Manager API

## Project Description
The **Task Manager API** is a simple Laravel-based RESTful API that allows users to manage their tasks. It includes authentication using Laravel Sanctum and provides CRUD operations for tasks.

---

## Installation
### Prerequisites:
- PHP (>= 8.1)
- Composer
- Laravel (>= 10.x)
- MySQL or SQLite

### Setup Instructions:
1. **Clone the Repository:**
   ```sh
   git clone https://github.com/your-repo/task-manager-api.git
   cd task-manager-api
   ```
2. **Install Dependencies:**
   ```sh
   composer install
   ```
3. **Set Up Environment File:**
   ```sh
   cp .env.example .env
   ```
   - Configure your database settings in the `.env` file.

4. **Generate Application Key:**
   ```sh
   php artisan key:generate
   ```
5. **Run Migrations & Seed Database:**
   ```sh
   php artisan migrate --seed
   ```
6. **Start the Server:**
   ```sh
   php artisan serve
   ```
   The API will be available at `http://127.0.0.1:8000`

---

## API Endpoints

### Authentication
| Method | Endpoint        | Description         |
|--------|----------------|---------------------|
| POST   | `/api/register` | Register a new user |
| POST   | `/api/login`    | Login and get token |
| POST   | `/api/logout`   | Logout user        |

### Tasks
| Method | Endpoint            | Description                |
|--------|----------------------|----------------------------|
| GET    | `/api/tasks`         | List all tasks            |
| POST   | `/api/store-task`         | Create a new task         |
| PUT    | `/api/tasks/{task}`    | Update a specific task    |
| DELETE | `/api/tasks/{id}`    | Delete a specific task    |

---

## Authentication (Sanctum)
All task-related endpoints require authentication.
- After logging in, include the token in your requests:
  ```sh
  Authorization: Bearer YOUR_ACCESS_TOKEN
  ```

---

---

## License
This project is open-source and available under the **MIT License**.

---

## Author
- **Mohamed Hassan**
- GitHub: [Mohamed-Hassan](https://github.com/Moha1234567890)

