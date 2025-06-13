# 🎉 Events Manager API (Laravel)

A RESTful API built with Laravel 12 for managing **Events** and their **Attendees**. Includes:

- 🛡️ **Bearer token authentication**
- 🏠 **Ownership & Policy-based authorization**
- ✉️ **Email reminders to attendees for imminent events**
- 🗓️ **Scheduled commands & queue-based sending**
- 🚦 **Rate limiting (throttling)**


---

## ⚙️ Features

- Standard CRUD operations for **Events**, including updating or deleting by owners.
- Manage **Attendees**, including removal from guest lists.
- Route protection via **Bearer token** authentication.
- Custom **policies** ensuring users can only modify their own events/attendees.
- **Email reminders** sent to attendees within 24h of event start.
- Utilizes Laravel's **scheduling**, **queues**, and **throttling** out of the box.

---

## 🚀 Setup & Installation

Clone and install dependencies:

```bash
git clone https://github.com/youruser/events-manager-api.git
cd events-manager-api
composer install
cp .env.example .env
php artisan key:generate
```
then:

```bash
docker compose up  #to confirgure on your localhost mysql and the mailpit
```
Run migrations and seed data:

```bash
php artisan migrate --seed
php artisan app:send-event-reminders #run the custom comand to put all jobs in the queue
php artisan queue:work  # to process email jobs
```

🛂 Authentication
Issue a token for a user:
> POST /login?email=user@example.com&password=secret

You'll receive an XSRF-TOKEN cookie and Bearer token for authenticated requests.
Use header:

> Authorization: Bearer {token}

📌 API Endpoints


| Method | Endpoint                           | Description                | Auth |
| :----: | ---------------------------------- | -------------------------- | :--: |
|   GET  | `/api/events`                      | List all events            |   ✅  |
|   GET  | `/api/events/{id}`                 | Show specific event        |   ✅  |
|  POST  | `/api/events`                      | Create a new event         |   ✅  |
|   PUT  | `/api/events/{id}`                 | Update an existing event   |  ✅¹  |
| DELETE | `/api/events/{id}`                 | Delete an existing event   |  ✅¹  |
| DELETE | `/api/events/{id}/attendees/{aid}` | Remove attendee from event |  ✅¹  |

¹ Requires ownership – enforced via Policies.

🏛️ Policies & Authorization

EventPolicy: Allows only owners to update or delete their own events.
AttendeePolicy: Allows removal only by event owners.
Applies using:

> $this->authorize('update', $event);

<br>
⏰ Scheduling & Queue

bootstrap/app.php defines scheduling via withSchedule(...).

Jobs are dispatched to the database queue and processed asynchronously by php artisan queue:work.

<br>
🚥 Rate Limiting (Throttling)

All API routes are protected using Laravel’s throttle:60,1 middleware to prevent excessive requests.

<br>
🗂️ Database & Seeding

MySQL with events, attendees, users tables.

Seeder populates mock attendees with realistic emails.

<br>
🧪 Screenshots & Flow
<br>
Emails queued & sent: 
![image](https://github.com/user-attachments/assets/b2aa3930-409a-4e67-a418-973aea0eca50) <br>
![image](https://github.com/user-attachments/assets/590e0fe5-a1e1-4def-9831-53fc15e1258a)

<br>

Sample API request:
![image](https://github.com/user-attachments/assets/d9fc8f7b-722c-4ef5-afb0-0226f4ec72b1) <br>
![image](https://github.com/user-attachments/assets/e52d299e-6afb-4105-ad0d-f51435f892b1) <br>
![image](https://github.com/user-attachments/assets/7ba77c56-99e2-4741-9f8e-929a326231a9)



