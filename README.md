<p align="center">
<img src="public/enrollify-logo.svg" width="300" alt="Enrollify Logo">
</p>

## About Enrollify

Enrollify is a course platform where you can enroll yourself to a course consisting of various lessons, which includes text or video content.

You can create, edit, or delete your own courses.

## Usage

The application is Dockerized using [Laravel Sail](https://laravel.com/docs/11.x/sail) so no need any other dependancy except Docker 🐋.

First run the installation script to pull and build the required docker images for Laravel and MySQL and also to install composer requirements:

```bash
git clone https://github.com/IvoKara/enrollify
cd enrollify
./install.sh
```

When installed the docker containers should be run using:

```bash
./vendor/bin/sail up -d
```

For simplicity purposes you can add this alias to your `.bashrc` file:

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

So that you can just:

```bash
sail up -d
```

Then you will need to install Node dependancies:

```bash
sail pnpm install
```

Than you are all done.

For running dev server on `http://localhost`:

```bash
sail pnpm dev
```

For building the application:

```bash
sail pnpm dev
```

## Features

* Login / Register 🔒
* Profile Picture 📷
* Password Reset 🔐
* 2FA 2️⃣
* Fluent UI 🖼️
* Admin Dashboard 📊
* CRUD of ✨
  * Courses which includes many
    * Lessons which may include various
      * Text Content or
      * Video Content
* Media Library in Admin Dashboard 🗃️
* Calculation of duration (Text, Video, Lessons, Courses) ⏳
* Listing Courses 📜
* Enrolling User to Courses ▶️
* View Course content 🔎
