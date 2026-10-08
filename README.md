# Mr Usaame IT Portfolio

A personal portfolio and admin dashboard built with HTML, CSS, JavaScript, Bootstrap 5, PHP 8, and MySQL. It is meant to run on XAMPP.

## 1. Install XAMPP

Download XAMPP for Windows from [https://www.apachefriends.org/](https://www.apachefriends.org/) and install it. This project expects PHP 8 or newer.

## 2. Start Apache

Open the XAMPP Control Panel and click **Start** next to Apache.

## 3. Start MySQL

In the same XAMPP Control Panel, click **Start** next to MySQL.

## 4. Put the project in htdocs

Copy this folder to:

`C:\xampp\htdocs\mrusaame-portfolio`

The folder name in that path is what appears in the browser address.

## 5. Import the database

1. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2. Click **Import**.
3. Choose `database/database.sql`.
4. Click **Go**.

This creates the database `mrusaame_portfolio`, the tables, the starter content, and the first administrator account.

Importing the file again deletes the current site content and loads the starter content again.

## 6. Database login

Open `config/database.php`.

XAMPP’s usual local settings are already there:

- Host: `localhost`
- Database: `mrusaame_portfolio`
- Username: `root`
- Password: empty

Change `DB_USER` and `DB_PASS` if your MySQL account is different. Set `APP_DEBUG` to `false` before you put the site on the internet.

## 7. Open the website

[http://localhost/mrusaame-portfolio/](http://localhost/mrusaame-portfolio/)

## 8. Open the admin dashboard

[http://localhost/mrusaame-portfolio/admin/](http://localhost/mrusaame-portfolio/admin/)

### First administrator

- Email: `admin@mrusaame.local`
- Password: `ChangeMe123!`

This password is only for your computer. Change it immediately after you log in:

**Admin → Profile → Change password**

You can also change the login email in **Admin → Profile → Administrator login**.

Passwords are stored with `password_hash()`. The site checks them with `password_verify()`. The plain password is not saved in the database.

## Where to edit the site

| What you want to change | Where |
| --- | --- |
| Name, about text, photo, phone, WhatsApp, public email | Admin → Profile |
| Login email and password | Admin → Profile |
| YouTube heading, channel link, hero text, footer, logo, favicon | Admin → Site Settings |
| Footer icons for YouTube, Facebook, LinkedIn, GitHub, WhatsApp, and email | Admin → Social Links |
| Projects, services, skills, courses, testimonials | The matching item in the admin sidebar |
| Messages sent from the contact form | Admin → Messages |
| Uploaded photos | `assets/uploads/` |

Only JPG, PNG, and WEBP files up to 2MB are accepted.

## Add, edit, or delete content

1. Log in at `/admin/`.
2. Open Projects, Services, Skills, Courses, or Testimonials.
3. Use **Add**, **Edit**, **Delete**, and **Publish / Unpublish** (or **Enable / Disable** for skills and services).

Hidden and unpublished items stay in the dashboard and do not show on the public website.

The two testimonials that come with the site are samples. They are labeled **Sample placeholder**. Replace them with words a real person has agreed to, or unpublish them.

## Put the site online

1. Buy hosting that provides PHP 8 and MySQL.
2. Create an empty MySQL database in the hosting panel.
3. Import `database/database.sql`. If the host does not allow `CREATE DATABASE`, delete those two lines from the top of the SQL file and select your database before importing.
4. Upload the project files.
5. Edit `config/database.php` with the host, database name, username, and password from your host.
6. Set `APP_DEBUG` to `false`.
7. Make sure `assets/uploads/` can be written by PHP.
8. Change the administrator password before you share the site.
9. Visit the admin URL on your domain, for example `https://yourdomain.com/admin/`.
