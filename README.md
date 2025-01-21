## Notes App

-   This is an application that lets user create, read, edit and delete notes with title and content.
-   The title cannot be longer than 127 characters and for the content the limit is set to 1023 characters.

## Features included are

-   Create Note
-   Display all Notes
-   Read a Particular Note
-   Update a Note

## Pre-requisites

-   PHP: 8.4.3
-   Laravel: 11.x
-   Composer: 2.8.4
-   MySQL: 9.1.0

## Installation Instructions

1. **Clone the Repository**:

    ```bash
    git clone https://github.com/yourusername/notes-app.git
    cd notes-app

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
