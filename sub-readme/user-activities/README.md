# USER ACTIVITIES ENDPOINT
<a href="../../README.md"><strong>« back to menu</strong></a>

<details open="open">
  <summary>Table of Contents</summary>
  <ul>
    <li><a href="#11-user-register">user register</a></li>
    <li><a href="#12-login">login</a></li>
    <li><a href="#13-user-session">user session</a></li>
    <li><a href="#14-user-update">user update</a></li>
    <li><a href="#15-logout">logout</a></li>
    <li><a href="#16-delete">delete</a></li>
  </ul>
</details>

## 1.1 user register
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/user/register
    ```
* **Request method** <br>
`POST`
* **Params body** <br>

    | PARAMETER | REQUIRED | UNIQUE | TYPE   | MIN_LENGTH | MAX_LENGTH |
    | :--:      |  :--:    |  :--:  |  :--:  |  :--:      |  :--:      |
    |email      | yes      | yes    | text   | 8 char     | 30 char    |
    |username   | yes      | yes    | text   | 8 char     | 20 char    |
    |password   | yes      | no     | text   | 8 char     | 20 char    |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "user register is success" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.2 login
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/user/login
    ```
* **Request method** <br>
`POST`
* **Params body** <br>

    | PARAMETER | REQUIRED | TYPE |
    | :--:      |  :--:    |  :--:|
    |username   | yes      | text |
    |password   | yes      | text |

* **Success response**
    * **code :** 200 Ok<br />
      **json :** 
      ```
      { 
        "success": true,
        "data": {
            user_id:"",
            api_key:"",
            token:"",
        } 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad request<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`
* **Notes:** <br>
*token lifetime is 1 hour*

## 1.3 user session
* **Request method** <br>
`GET`
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/user/session
    ```
* **Params header** 
  - api-key  <br>
  - token  <br>
* **Success response**
    * **code :** 200 Ok<br />
      **json :** 
      ```
      { 
        "success": true,
        "data": {
            user_id:"",
            token_age:"",
        } 
      }
      ```
* **Error Response:**
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.4 user update
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/user/edit
    ```
* **Request method** <br>
`PUT`
* **Params header** 
  - api-key  <br>
  - token  <br>
* **Params body** <br>

    | PARAMETER  | REQUIRED | UNIQUE | TYPE   | MIN_LENGTH | MAX_LENGTH |
    | :--:       |  :--:    |  :--:  |  :--:  |  :--:      |  :--:      |
    |new_username| yes      | yes    | text   | 8 char     | 20 char    |
    |new_password| yes      | yes    | text   | 8 char     | 20 char    |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "edit user is success"
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.5 logout
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/user/logout
    ```
* **Request method** <br>
`DELETE`
* **Params header** 
  - api-key  <br>
  - token  <br>
* **Success response**
    * **code :** 202 Accepted<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "logout success"
      }
      ```
* **Error Response:**
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`


## 1.6 delete
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/user/delete
    ```
* **Request method** <br>
`DELETE`
* **Params header** 
  - api-key  <br>
  - token  <br>
* **Success response**
    * **code :** 202 Accepted<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "delete account success"
      }
      ```
* **Error Response:**
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`