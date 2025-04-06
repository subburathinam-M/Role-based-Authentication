# ⚙️ Role-based Authentication with Microsoft Login🔐 - Laravel

A Laravel-based authentication system featuring role-based routing and Microsoft OAuth2 login via Laravel Socialite. Users are authenticated based on their role (Admin, SuperAdmin, DeptHead, or User), and redirected accordingly.

---

## 📌 Features

- ✅ Role-based login & dashboard redirection
- 🔐 Secure Microsoft login using OAuth2
- 🧠 Uses Laravel Socialite for Microsoft auth
- 📀 User info stored in database
- 🧪 Tinker support for quick user creation
- 🌐 Environment-specific setup

---

## 🚧 Common Issue Faced & Fix

❌ **Problem:**
> After cloning and running on a different machine (Personal laptop), Microsoft login threw:
>
> `InvalidStateException`  
>
> This was caused because sessions weren't correctly managed on the new environment.

✅ **Fix:**
In `MicrosoftAuthController`, update:

```php
$mUser = Socialite::driver('microsoft')->stateless()->user();
```

Use `->stateless()` when session-based state matching doesn't work (common in localhost or different PCs).

---

## 🛠️ Installation Steps

### 1. Clone the Repo

```bash
git clone https://github.com/subburathinam-M/Role-based-Authentication.git
cd Role-based-Authentication
```

### 2. Install PHP & JavaScript Dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Setup `.env`

Duplicate `.env.example` and rename it to `.env`:

```bash
cp .env.example .env
```

Then set your DB and Microsoft login credentials:

```
DB_DATABASE=Role_based_Authentication
DB_USERNAME=root
DB_PASSWORD=

MICROSOFT_CLIENT_ID=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
MICROSOFT_CLIENT_SECRET=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback
```

### 4. Generate Key and Migrate

```bash
php artisan key:generate
php artisan migrate
```

---

## 🤩 Project Folder Structure (Simplified)

```
Role-based-Authentication/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php
│   │       └── MicrosoftAuthController.php
│
├── resources/
│   └── views/
│       └── auth/
│           └── login.blade.php
│
├── routes/
│   └── web.php
│
├── database/
│   └── migrations/
│   └── seeders/
│   └── user-seed.sql ✅ Import this file
│
├── .env
├── composer.json
├── package.json
└── README.md 📄
```

---

⚙️ Setup Instructions

#### 1️⃣ Database Configuration

- Create a database in **phpMyAdmin** (e.g., `Role_based_Authentication`)
- Import the SQL file from `database/import_db/users.sql`
- Or use Laravel Tinker:

## 🧪 Laravel Tinker Commands (User Setup)

### 👉 Create User via Tinker

```bash
php artisan tinker

use App\Models\User;

User::create([
    'name' => 'Subburathinam',
    'email' => 'subburathinam@hepl.com',
    'password' => bcrypt('12345678'),
    'role' => 'admin'
]);
```

### 🔀 Change Role

```php
$user = User::find(1);
$user->role = 'manager';
$user->save();
```
#### 👉  Run the Project
```bash
php artisan migrate --seed
php artisan serve
```

If the project doesn't work:
```bash
composer update
npm install
php artisan config:clear
php artisan view:clear
php artisan route:clear
```
---

## 🔐 Microsoft Login Setup on Azure

1. Visit [Azure Portal](https://portal.azure.com/)
2. Go to **Azure Active Directory > App registrations**
3. Click **New registration**
4. Enter:
   - **Name**: Role-based Auth Tool
   - **Supported account types**: *Accounts in any organizational directory and personal Microsoft accounts*
   - **Redirect URI**: `http://localhost:8000/auth/microsoft/callback`
5. After registration:
   - Copy the **Application (client) ID**
   - Go to **Certificates & secrets → New client secret**
6. In `.env`, set:

```env
MICROSOFT_CLIENT_ID=your-client-id
MICROSOFT_CLIENT_SECRET=your-secret
MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback
```
---

### 🔐 Microsoft OAuth Integration Steps

#### ✳️ Install Laravel Socialite
```bash
composer require laravel/socialite
```

#### ✳️ Install Microsoft Provider
```bash
composer require socialiteproviders/microsoft
```

#### ✳️ Update `config/services.php`
```php
'microsoft' => [
    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'redirect' => env('MICROSOFT_REDIRECT_URI'),
],
```

#### ✳️ Update `.env`
```
MICROSOFT_CLIENT_ID=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
MICROSOFT_CLIENT_SECRET=your-microsoft-secret-key
MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback
```

#### ✳️ Add Events in `EventServiceProvider.php`
```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        \SocialiteProviders\Microsoft\MicrosoftExtendSocialite::class.'@handle',
    ],
];
```

#### 🛠 Fix: Microsoft `InvalidStateException`
On some local machines (like personal laptops), sessions may not persist properly.
✅ Use stateless login:
```php
$mUser = Socialite::driver('microsoft')->stateless()->user();
```

✅ Ensure your redirect URI is correctly set in Azure:
> [https://portal.azure.com](https://portal.azure.com) → App Registrations → Authentication → Add Redirect URI:
> http://localhost:8000/auth/microsoft/callback    

---

### 📢 Notes
- Default route after login is based on user role (admin, user, etc.)
- Default password is hashed: `bcrypt('12345678')`
- Admin dashboard: `/admin`, User dashboard: `/user`, etc.

---

## 🔄 Routes Overview

| Route                             | Description               |
|----------------------------------|---------------------------|
| `/login`                         | Default login screen      |
| `/auth/microsoft/redirect`      | Start Microsoft login     |
| `/auth/microsoft/callback`      | Handle Microsoft response |
| `/admin`                         | Admin dashboard           |
| `/user`                          | User dashboard            |

---
```
## 💡 Tips

- Make sure your **sessions** are correctly configured.
- If moving across machines, **clear sessions** with:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```


## 🚀 Run the App

```bash
php artisan serve
```

Then open:  
👉 `http://localhost:8000`

---


### ✨ Icons Legend
- 📁 = Folder
- 📄 = File
- 🔐 = Security/Auth
- ✳️ = Step
- ✅ = Solution
- ⚙️ = Setup/Config
- 🔁 = Update
- 📢 = Note

---

## 🧠 Author

**Subburathinam** - Java & Laravel Developer  
🔗 GitHub: [subburathinam-M](https://github.com/subburathinam-M)

---

🧶 Made with Laravel + Microsoft Azure + Socialite

