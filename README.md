## Requirements

- PHP 7.4
- Composer

## Installation

1. **Install Composer** (if not already installed):
Visit [Composer installation page](https://getcomposer.org/download/) to download and install.

2. **Install necessary libraries**:

In the project directory, run the following command to install dependencies:

```
composer install
```

3. **Verify and configure PHP extensions**:

Make sure the `mbstring` and `openssl` extensions are enabled in the `php.ini` file. To check, use this command to see the path to the current `php.ini` file:

```
php --ini
```

## Run Unit Tests

To execute the unit tests, use the command:

```
vendor\bin\phpunit --bootstrap vendor/autoload.php tests/
```

**Note**: Make sure you are in the project root directory when running this command.

## Directory Structure

-   **src/**: Contains the main source code of the project.
-   **tests/**: Contains the unit test files for the project.
-   **vendor/**: Directory containing third-party libraries installed via Composer.