# Content
  1. Installation
  2. API Endpoints

# Installation:

## Prerequisites:
   - Docker running

1. Clone the project:
   - `git clone https://github.com/roninds14/vacation-plan-app.git`

2. In the main project folder rename the file **'.env.example'** to **'.env'**.

3. Open a command terminal in the directory where the project was cloned.

4. Run the command to build and start the project:
   - `docker-compose up --build -d`
 
5. Install the Composer dependencies:
   - Run: `docker-compose exec app composer install`.
     - Wait for it to complete; this might take some time.

6. Install Passport:
 - Run: `docker-compose exec app php artisan passport:install`
   - You might see the error: ***'ERROR Encryption keys already exist. Use the --force option to overwrite them'***. Don’t worry.
   - When asked, ***'Would you like to run all pending database migrations?'*** answer yes.
   - When asked, ***'Would you like to create the 'personal access' and 'password grant' clients?'*** answer yes.

7. __Done!!!__ Now you can run the project easily.

### Optional:
9. To make your life easier, import the Collection and Environment of the project into Postman. The files are in the main project folder:
   - Collection: **'VacationPlan.postman_collection.json'**
   - Environment: **'VacationPlanEnvironment.postman_environment.json'**
     - PS: Don’t forget to activate the environment.

10. To shut down, run: `docker-compose down -v`

### Instalation Video
[![Watch the video](https://github.com/roninds14/vacation-plan-app/blob/main/youtube-logotype.jpg?raw=true)](https://youtu.be/ASa2jUtyyOs)

# API Endpoints

### Headers Parameters Documentation

1. Accept: application/json
   - The Accept header indicates that the client expects the server's response to be in JSON format. This is a common header in API requests where the client needs structured data that can be easily parsed.
   - `Accept: application/json`

2. Authorization: Bearer {{authToken}}
   - The Authorization header is used to pass authentication credentials to the server. The Bearer scheme is typically used with OAuth 2.0 or JWT tokens, where {{authToken}} is a placeholder for the actual token that authenticates the client.
   - `Authorization: Bearer <your-token-here>`

### Create a New Holiday Plan
- Method: **POST**
- URI: `/api/holiday`
- Request Body:
  - The request should be sent in JSON format. Below is the structure of the request body:
```
{
    "title": "Holiday Plan Title",
    "description": "Detailed description of the holiday plan",
    "date": "YYYY-MM-DD",
    "location": "Location of the holiday",
    "participants": [
        {
            "name": "Participant Name"
        }
    ]
}
```
 - Request Parameters:
   - title (String): The name or title of the holiday plan. This field is required.
     - Example: "Summer Vacation 2024"
   - description (String): A detailed description of the holiday plan. This field is required.
     - Example: "A week-long beach vacation with friends and family."
   - date (String): The date of the holiday in YYYY-MM-DD format. This field is required.
     - Example: "2024-08-20"
   - location (String): The location where the holiday will take place. This field is required.
     - Example: "Hawaii, USA"
   - participants (Array of Objects): A list of participants attending the holiday. Each participant object must include a "name" field. This field is optional.
     - Example:
```
[
    {
        "name": "John Doe"
    },
    {
        "name": "Jane Smith"
    }
]
```
- Response:
  - **201 Created**: If the holiday plan is successfully created, the server will respond with a status code of 201 and return a JSON object with the details of the created holiday plan.
  - **401 Unauthorized**: If the token is incorrect, the server will respond with a 401 status code and an error message.
  - **422 Unprocessable Entity**: If the request body is missing required fields or contains invalid data, the server will respond with a 422 status code and an error message.
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.
  - Example Response:
```
{
    "id": 2,
    "title": "dummyTitle",
    "description": "Lorem iupsum",
    "date": "2024-08-31",
    "location": "dummyLocation",
    "user_id": 1,
    "created_at": "2024-08-17T15:38:18.000000Z",
    "updated_at": "2024-08-17T15:38:18.000000Z",
    "participants": [
        {
            "id": 3,
            "holiday_id": 2,
            "name": "Participants 01",
            "created_at": "2024-08-17T15:38:18.000000Z",
            "updated_at": "2024-08-17T15:38:18.000000Z"
        },
        {
            "id": 4,
            "holiday_id": 2,
            "name": "Participants 02",
            "created_at": "2024-08-17T15:38:18.000000Z",
            "updated_at": "2024-08-17T15:38:18.000000Z"
        }
    ]
}
```

### Retrieve all holiday plans

- Method: **GET**
- URI: `/api/holiday`
- Response:
  - **200 Ok**: The server will respond with a status code of 200 and return a JSON object with the details of the created holiday plan.
  - **401 Unauthorized**: If the token is incorrect, the server will respond with a 401 status code and an error message.
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.
  - Example Response:
```
[
    [
        {
            "id": 1,
            "title": "dummyTitle",
            "description": "Lorem iupsum",
            "date": "2024-08-31",
            "location": "dummyLocation",
            "user_id": 1,
            "created_at": "2024-08-17T00:54:44.000000Z",
            "updated_at": "2024-08-17T00:54:44.000000Z",
            "participants": [
                {
                    "id": 1,
                    "holiday_id": 1,
                    "name": "Participants 01",
                    "created_at": "2024-08-17T00:54:44.000000Z",
                    "updated_at": "2024-08-17T00:54:44.000000Z"
                },
                {
                    "id": 2,
                    "holiday_id": 1,
                    "name": "Participants 02",
                    "created_at": "2024-08-17T00:54:44.000000Z",
                    "updated_at": "2024-08-17T00:54:44.000000Z"
                }
            ]
        }
    ]
    ...
]
```

### Retrieve a specific holiday plan by ID

- Method: **GET**
- URI: `/api/holiday/{id}`
- URI Path Parameter:
  - id (Integer): The unique identifier of the holiday plan to be recoverd. This is a required parameter.
- Response:
  - **200 Ok**: The server will respond with a status code of 200 and return a JSON object with the details of the created holiday plan.
  - **204 No Content**: The server will respond with a status code of 204 case no content are found.
  - **401 Unauthorized**: If the token is incorrect, the server will respond with a 401 status code and an error message.
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.
  - Example Response:
```
[
    {
        "id": 1,
        "title": "dummyTitle",
        "description": "Lorem iupsum",
        "date": "2024-08-31",
        "location": "dummyLocation",
        "user_id": 1,
        "created_at": "2024-08-17T00:54:44.000000Z",
        "updated_at": "2024-08-17T00:54:44.000000Z",
        "participants": [
            {
                "id": 1,
                "holiday_id": 1,
                "name": "Participants 01",
                "created_at": "2024-08-17T00:54:44.000000Z",
                "updated_at": "2024-08-17T00:54:44.000000Z"
            },
            {
                "id": 2,
                "holiday_id": 1,
                "name": "Participants 02",
                "created_at": "2024-08-17T00:54:44.000000Z",
                "updated_at": "2024-08-17T00:54:44.000000Z"
            }
        ]
    }
]
```

### Update an existing holiday plan

- Method: **PUT**
- URI: `/api/holiday/{id}`
- URI Path Parameter:
  - id (Integer): The unique identifier of the holiday plan to be updated. This is a required parameter.
- Request Body:
  - The request should be sent in JSON format. Below is the structure of the request body:
```
{
    "title": "dummyTitle",
    "description": "Lorem iupsum",
    "date":  "2024-08-31",
    "location": "dummyLocation",
    "participants": [
        {
            "name" : "Participants 03"
        },
        {
            "name" : "Participants 04"
        }
    ]
}
```
 - Request Parameters:
   - title (String): The name or title of the holiday plan. This field is required.
     - Example: "Summer Vacation 2024"
   - description (String): A detailed description of the holiday plan. This field is optional.
     - Example: "A week-long beach vacation with friends and family."
   - date (String): The date of the holiday in YYYY-MM-DD format. This field is required.
     - Example: "2024-08-20"
   - location (String): The location where the holiday will take place. This field is required.
     - Example: "Hawaii, USA"
   - participants|***optional*** (Array of Objects): A list of participants attending the holiday. Each participant object must include a "name" field. This field is required.
     - Example:
```
[
    {
        "name": "John Doe"
    },
    {
        "name": "Jane Smith"
    }
]
```
- Response:
  - **201 Created**: If the holiday plan is successfully created, the server will respond with a status code of 201 and return a JSON object with the details of the created holiday plan.
  - **204 No Content**: The server will respond with a status code of 204 case no content are found.
  - **400 Bad Request**: Case is not possible update de data the serve will returna bad request.
  - **401 Unauthorized**: If the token is incorrect, the server will respond with a 401 status code and an error message.
  - **422 Unprocessable Entity**: If the request body is missing required fields or contains invalid data, the server will respond with a 422 status code and an error message.
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.
  - Example Response:
```
{
    "id": 1,
    "title": "dummyTitle",
    "description": "Lorem iupsum",
    "date": "2024-08-31",
    "location": "dummyLocation",
    "user_id": 1,
    "created_at": "2024-08-17T00:54:44.000000Z",
    "updated_at": "2024-08-17T00:54:44.000000Z",
    "participants": [
        {
            "id": 5,
            "holiday_id": 1,
            "name": "Participants 03",
            "created_at": "2024-08-17T15:50:09.000000Z",
            "updated_at": "2024-08-17T15:50:09.000000Z"
        },
        {
            "id": 6,
            "holiday_id": 1,
            "name": "Participants 04",
            "created_at": "2024-08-17T15:50:09.000000Z",
            "updated_at": "2024-08-17T15:50:09.000000Z"
        }
    ]
}
```

### Delete a holiday plan

- Method: **DELETE**
- URI: `/api/holiday/{id}`
- URI Path Parameter:
  - id (Integer): The unique identifier of the holiday plan to be deledet. This is a required parameter.
- Response:
  - **200 Ok**: The server will respond with a status code of 200 and return a JSON object with the details of the created holiday plan.
  - **204 No Content**: The server will respond with a status code of 204 case no content to deleted are found.
  - **401 Unauthorized**: If the token is incorrect, the server will respond with a 401 status code and an error message.
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.
  - Example Response:
```
{
    "deleted": {
        "id": 1,
        "title": "dummyTitle",
        "description": "Lorem iupsum",
        "date": "2024-08-31",
        "location": "dummyLocation",
        "user_id": 1,
        "created_at": "2024-08-17T00:54:44.000000Z",
        "updated_at": "2024-08-17T00:54:44.000000Z",
        "participants": [
            {
                "id": 5,
                "holiday_id": 1,
                "name": "Participants 03",
                "created_at": "2024-08-17T15:50:09.000000Z",
                "updated_at": "2024-08-17T15:50:09.000000Z"
            },
            {
                "id": 6,
                "holiday_id": 1,
                "name": "Participants 04",
                "created_at": "2024-08-17T15:50:09.000000Z",
                "updated_at": "2024-08-17T15:50:09.000000Z"
            }
        ]
    }
}
```

### Trigger PDF generation for a specific holiday plan

- Method: **POST**
- URI: `/api/holiday/pdf`
- Response:
  - A PDF file with all holiday data will be returned
  - Example:
![alt text](https://github.com/roninds14/vacation-plan-app/blob/main/pdf-example.PNG?raw=true)

## Authorization Endpoinds - The following endpoints do not need parameters in the header

### User Registration
- Method: **POST**
- URI: `/api/register`
- Request Body:
  - The request should be sent in JSON format. Below is the structure of the request body:
```
{
    "name": "roni",
    "email": "roni@email.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```
 - Request Parameters:
   - name (String): The name of the user registering for the account. This field is required.
     - Example: "roni"
   - email (String): The email address of the user. It must be unique and in a valid email format. This field is required.
     - Example: "roni@email.com"
   - password (String): The password for the user's account. It must meet the application's password policy (e.g., minimum length, complexity). This field is required.
     - Example: "123456"
   - password_confirmation (String): This field should match the password field exactly, ensuring that the user has correctly typed their desired password. This field is required.
     - Example: "123456"

- Response:
  - **200 Ok**: If the registration is successful, the server will respond with a status code of 200 and return a JSON object.
    - Example Response:
```
{
    "status": 1,
    "message": "User created successfully"
}
```
  - **401 Unauthorized**: If the token is incorrect, the server will respond with a 401 status code and an error message.
  - **422 Unprocessable Content**: If the request body is missing required fields or contains invalid data, the server will respond with a 422 status code and an error message.
    - Example Response:
```
{
    "error": "Validation failed. The email has already been taken.",
    "data": {
        "name": "roni",
        "email": "roni@email.com",
        "password": "123456",
        "password_confirmation": "123456"
    }
}
```
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.

  - Notes:
    - Ensure that the password and password_confirmation fields match exactly.
    - The email field must be unique; otherwise, the registration will fail with a conflict error.

### User Login

- Method: POST
- URI: `/api/login`
- Request Body:
  - The request must be sent in JSON format. Below is the structure of the request body:
```
{
    "email": "roni@email.com",
    "password": "123456"
}
```
- Request Parameters:
  - email (String): The email address of the user trying to log in. This field is required.
    - Example: "roni@email.com"
  - password (String): The password associated with the user's account. This field is required.
    - Example: "123456"
- Response:
  - **200 OK**: If the login is successful, the server will respond with a status code of 200 and return a JSON object containing the user's authentication token and possibly other user details.
```
{
    "status": true,
    "message": "User logged successfully",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjRkYzM4ODA3YTViMjcwNmFiYTBiMDZhY2NjZjQxN2U0MTBhMzFhNGY2NDA1ZTQ2YmRmNjFlZjIyNjQzMGQzNDlkYWM4MmZiN2UzZGI2ZmQiLCJpYXQiOjE3MjM5MTI4MDEuNDY3NzQ0LCJuYmYiOjE3MjM5MTI4MDEuNDY3NzQ3LCJleHAiOjE3NTU0NDg4MDEuMzE5MDE2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.NdZ7XZrZFtiIeGR6eCw2qrACCBxrpr1OCd0Fh4eJ6lcVbNal78Iox1iLzJntgXmxJ6A2SMtcXsEH3PNzNqJrtPKM_GNpOc_38MHgNS1ciDiVGPigav7i4xb935NsKbcoTRBE-9hxLw_z64wdzlcIdQsN2UbtYA8BoJCu4Jeftk21fQFrBU-SDAWFGK_WmQQMlaBUR9kbvxiQ_UTnQLhBdZIV3XqVrmJBDvhCBIVUBg5soEjJbP3KbeqGg6yH-X35vB5zt7Bkzyb7YWyVGFcM7x3cbDtHV6iDYT4oAv0AUqA3k0pEmI3ak1DI-mni_UyccSktNhGHyCOGcKPGk-rrE7Jah9GEMCn1c2WWRwOswqDhacMqgIRRg_NbrzzdXmh6Iv38CYxQZAyBcrr5SXx8pkY92XM7CtLpv2xA9HAGX3LCnAvLlDisWxIVA2BVFYP_94FiG_FZKewVWkB9EtR_E4M6kDjTWRfakmggNUuw1zangoZYR-icw40NqHG207ximUyvx7UJ1sUnHm1DIpx1XFLsD65hCAZk0UfK7i_zP9j6K94wOUIrv7KC0eavRWGpinpEHuD-BIxlgqn9m8elGlm80tGbtoWRHMYtrwy_BFYsEEbMA6YTk3Nl37PGarXgaqE-vmqqvUus7zm6rwINPGuV-LkkFjGzI0WbLsQrcW4"
}
```
or
```
{
    "status": false,
    "message": "Invalid loging details"
}
```
  - **500 Internal Server Error**: If there's an issue on the server, it will respond with a 500 status code and an error message.


### Running Video
[![Watch the video](https://github.com/roninds14/vacation-plan-app/blob/main/youtube-logotype.jpg?raw=true)](https://youtu.be/BY4NlD31LUI)

# Online App
`https://k3t.181.mytemp.website/laravel-vacation/api`