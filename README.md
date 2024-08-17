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

# API Endpoints

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