# backend_test
HUMAPRO BACKEND TEST

# GOALS
    - Create POSTGRESQL DATABASE (OK)
        - name: humapro (OK)
        - create user table (OK)
            - columns (minimal):
                - email (string)
                - id (uuid)
                - first_name (string)
                - last_name (string)
            - create an default user in migration (OK)

    - Create REST webservice login (NOK)
        - parameters (NOK)
            - Email (string)
            - Password (string)
        - Response (NOK)
            - Token (string)

    - Create REST webservice user (NOK)
        - header (NOK)
            - AUTHORIZATION = TOKEN (string)
        - Response (NOK)
            - last_name (string)
            - first_name (string)
    
    - Create REST webservice logout (NOK)
        - Parameters (NOK)
            - Token (string)
        - Response:
            - success (boolean)

# USED BUNDLES
    - ORM
        composer req symfony/orm-pack
        composer req ramsey/uuid-doctrine
        composer req symfony/maker-bundle --dev -W
        composer require orm-fixtures --dev
    - TO CREATE an user table
        composer req symfony/security-bundle



# INITIALIZE PROJECT PROCESS
    - connect to a terminal and go to the project folder
    
    - initialize database
        - configure your database in .env (DATABASE_URL default values):
            db name: humapro
            db user: athevenin
            db password: athevenin
            db host: 127.0.0.1
            db port: 5432

        - to create the database, excecute:
            bin/console doctrine:database:create
        - check database creation (you see your new database humapro), excecute:
            psql -l

        - to create the database schema and run migration, excecute:
            bin/console doctrine:migrations:migrate
        - check migration (you should see table users in database humapro)
            psql humapro -c 'SELECT * FROM users;'
        
    - run project
        php -S 127.0.0.1:8000 -t public

# WEBSERVICE EXAMPLES