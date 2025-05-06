# Event Management Application

This is a personal project in which users can create, update and delete the events and the people (attendees) who attends those events. Through its REST API endpoints, authenticated users can create events/attendees, and authorizated users (event owners or attendee himself) can update/delete their records. Laravel 11 authentication and authorization are used to implement those features.

## Run Locally

Make a .env file from .env.example

Install dependencies and create the Event Management database

```bash
  composer install
  php artisan migrate
```

Start the local server

```bash
  php artisan serve
```
