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

    - Create REST webservice login (OK)
        - parameters (OK)
            - Email (string)
            - Password (string)
        - Response (OK)
            - Token (string)

    - Create REST webservice profile (OK)
        - header (OK)
            - AUTHORIZATION = TOKEN (string)
        - Response (NOK)
            - last_name (string)
            - first_name (string)
    
    - Create REST webservice logout (OK)
        - header (OK)
            - AUTHORIZATION = TOKEN (string)
        - Response:
            - success (boolean)

# USED BUNDLES
    - ORM and RELATED TOOLS
        composer req symfony/orm-pack
        composer req ramsey/uuid-doctrine
        composer req symfony/maker-bundle --dev -W
        composer req orm-fixtures --dev
    - TO CREATE an user table
        composer req symfony/security-bundle
    - FOR email validator
        composer req symfony/validator
    - To limite access to some webservice endpoint
        composer req sensio/framework-extra-bundle

# USEFULL FILES
    - src/Entity/User.php: corresponding to table users in database to humapro.
    - src/Controller/UserController.php: webservice endpoints related to User.
    - src/Security/TokenAuthenticator.php: handler authentication by token. 

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
        - check migration (you should see table users with one user in database humapro)
            psql humapro -c 'SELECT * FROM users;'
        
    - run project
        php -S 127.0.0.1:8000 -t public

# WEBSERVICE EXAMPLES
    - /login:
        -request:
            curl --location --request POST 'http://127.0.0.1:8000/login' \
            --header 'Content-Type: application/json' \
            --data-raw '{
            "email": "email@email.fr",
            "password": "athevenin"
            }'
        -response:
            {"token":"597915ca6aee1fd0967984458d74d0916be4d4f2d3b8179d36d56b97e817aaace7e062f91b20bd66384058de93e90eda8ad24c8d4815b3dd631ddbe9"}
    
    - /profile (do not forget to replace the token)
        -request:
            curl --location --request GET 'http://127.0.0.1:8000/profile' \
            --header 'X-AUTH-TOKEN: 597915ca6aee1fd0967984458d74d0916be4d4f2d3b8179d36d56b97e817aaace7e062f91b20bd66384058de93e90eda8ad24c8d4815b3dd631ddbe9' \
            --header 'Cookie: PHPSESSID=81e8561783a9e9f3e5d74d5fedcee8c7' \
            --data-raw ''
        -response:
            {"first_name":"anthony","last_name":"thevenin"}
    
    - /logout (do not forget to replace the token)
        -request:
            curl --location --request POST 'http://127.0.0.1:8000/logout' \
            --header 'X-AUTH-TOKEN: 597915ca6aee1fd0967984458d74d0916be4d4f2d3b8179d36d56b97e817aaace7e062f91b20bd66384058de93e90eda8ad24c8d4815b3dd631ddbe9' \
            --header 'Content-Type: application/json' \
            --header 'Cookie: PHPSESSID=81e8561783a9e9f3e5d74d5fedcee8c7' \
            --data-raw '{
                "email": "email@email.fr",
                "password": "athevenin"
            }'
        -response:
            {"success":true}