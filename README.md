## Notes App

This is a backend API that allows users to create, read, update, and delete notes, each consisting of a title and content. The title has a maximum length of 127 characters, while the content is limited to 1023 characters. This application leverages Redis for caching, ensuring quick response times and improved performance.

## Table of Contents

-   [Notes App](#notes-app)
-   [Table of Contents](#table-of-contents)
-   [Features](#features)
-   [Pre-requisites](#pre-requisites)
-   [Installation Instructions](#installation-instructions)
-   [Docker Setup](#docker-setup)

## Features

-   Create Note
-   Display all Notes
-   Read a Particular Note
-   Update a Note
-   Delete a Note

## Pre-requisites

-   PHP: 8.4.3
-   Laravel: 11.x
-   Composer: 2.8.4
-   MySQL: 9.1.0
-   Redis-CLI: 7.2.7
-   Docker: 27.5.0 & Docker Desktop (optional)
-   Postman to send requests to the API (optional)

## Installation Instructions

1. **Clone the Repository**:

    ```bash
    git clone https://github.com/Samarth-twid/Notes_App.git
    cd Notes_App

    ```

2. **Install Dependencies**:

    ```bash
    composer install

    ```

3. **Set Up Environment Variables**:

    ```bash
    cp .env.example .env

    ```

4. **Run Migrations**:

    ```bash
    php artisan migrate

    ```

5. **Start the server**:

    ```bash
    php artisan serve

    ```

6. **Run tests (for developers)**:

    ```bash
    php artisan test

    ```

## Docker Setup

To run the Notes App using Docker, follow these steps:

1. Build images based on the services specified in docker-compose.yml:

    ```bash
    docker-compose build

    ```

2. Get the docker containers up for each of the service:

    ```bash
    docker-compose up

    ```

3. Open the nginx container URL or go to http://localhost:8080 on your device.

4. Jenkinsfile added and README changed to trigger the build.
