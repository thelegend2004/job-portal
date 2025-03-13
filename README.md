# Job Portal

This is a job portal application built with Laravel.

## Requirements

-   Docker
-   Docker Compose

## Installation

1. Clone the repository:

    ```sh
    git clone https://github.com/thelegend2004/job-portal.git
    cd job-portal
    ```

2. Copy the example environment file and update the environment variables as needed:

    ```sh
    cp .env.example .env
    ```

3. Start the Docker containers:

    ```sh
    ./vendor/bin/sail up -d
    ```

4. Install the dependencies:

    ```sh
    ./vendor/bin/sail composer install
    ```

5. Generate the application key:

    ```sh
    ./vendor/bin/sail artisan key:generate
    ```

6. Run the database migrations:

    ```sh
    ./vendor/bin/sail artisan migrate
    ```

7. (Optional) Seed the database with sample data:

    ```sh
    ./vendor/bin/sail artisan db:seed
    ```

## Usage

1. Access the application in your web browser:

    ```
    http://localhost
    ```

2. View the API documentation:

    ```
    http://localhost/api/documentation
    ```

## Testing

Run the test suite:

```sh
./vendor/bin/sail artisan test
```
