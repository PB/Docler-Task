# Docler-Task

## Installation
 - To run the application execute:

    `docker-compose up api`
    
    In the browser enter:
   
    `http://0.0.0.0:8080/`

    You should see the welcome page.

    The application comes with one example user and a few example tasks.
    The example data is a part of migrations, which is not an elegant way, but it only for demonstration purposes.
   
    In the browser enter:
    `http://0.0.0.0:8080/users/8cdf1af4-a1ce-43f1-a082-a183d71fd685/tasks`
   
    You should see a list of tasks for today.

## Tests 
- To run tests:

    `docker-compose rm -f db-test && docker-compose run test`

    This command will remove test database (if present) and perform test (and set up a test db):
    - phpunit with coverage
    - phpcs
    - phpstan
    
    One of the tests is using db, which is not a real unit test, but it checks db connection (so more integration test).
   