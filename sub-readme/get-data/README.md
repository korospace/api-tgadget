# GET DATA ENDPOINT
<a href="../../README.md"><strong>« back to menu</strong></a>

* **Request method** <br>
`GET`
* **Request header** <br>
    - api-key  <br>
* **Success response**
    * **code :** 200 Ok<br />
      **json :** 
      ```
      { 
        "success": true,
        "data": "{ . . .}" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 404 Not Found<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

* **URLs** <br>

  | DATA OF            | URL               | MORE INFO |
  | :---               |  :---             |  :---     |
  | socialmedia link   |  /get/socialmedia |  -        |
  | upcoming event     |  /get/countdown   |  -        |
  | product categories |  /get/categories  |  -        |
  | product keywords   |  /get/keywords    |  -        |
  | image banners      |  /get/banners     |  -        |
  | image testimonies  |  /get/testimonies |  -        |
  | statistics         |  /get/statistics  |  -        |
  | all products       |  /get/products    |  -        |
  | product by id                  |  /get/products?id=:id                       | - |
  | products by category           |  /get/products?kategory=:kategori           | - |
  | products by keyword            |  /get/products?keyword=:kategori            | - |
  | products using offset & limit  |  /get/products?limit=:limit&offset=:offset  |  *offset & limit*<br>*must integer*  |