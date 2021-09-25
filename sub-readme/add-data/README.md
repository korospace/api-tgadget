# ADD DATA ENDPOINT
<a href="../../README.md"><strong>« back to menu</strong></a>

<details open="open">
  <summary>Table of Contents</summary>
  <ul>
    <li><a href="#11-add-product-category">add product category</a></li>
    <li><a href="#12-add-testimoni">add testimoni</a></li>
    <li><a href="#13-add-banner">add banner</a></li>
    <li><a href="#14-add-product">add product</a></li>
  </ul>
</details>

## 1.1 add product category
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/add/category
    ```
* **Request method** <br>
`POST`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 

    | PARAMETER   | REQUIRED | UNIQUE | TYPE   | MAX_LENGTH |
    | :--:        |  :--:    |  :--:  |  :--:  | :--:       |
    |category_name| yes      | yes    | text   | 20 char    |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "add category is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.2 add testimoni
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/add/testimony
    ```
* **Request method** <br>
`POST`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 

    | PARAMETER | REQUIRED | TYPE          | MAX_SIZE |
    | :--:      |  :--:    |  :--:         | :--:     |
    |img_testi  | yes      | webp,jpeg,png | 200kb    |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "add testimony is success" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.3 add banner
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/add/banner
    ```
* **Request method** <br>
`POST`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 

    | PARAMETER    | REQUIRED | TYPE          | MAX_SIZE |
    | :--:         |  :--:    |  :--:         | :--:     |
    |banner_desktop| yes      | webp,jpeg,png | 200kb    |
    |banner_mobile | yes      | webp,jpeg,png | 200kb    |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "add banner is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.4 add product
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/add/product
    ```
* **Request method** <br>
`POST`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 

    | PARAMETER  | REQUIRED  | UNIQUE | TYPE          | MAX_LENGTH |
    | :--:       |  :--:     |  :--:  | :--:          | :--:       |
    |product_name| yes       | yes    | text          | 250 char   |
    |price       | yes       | no     | num           | 11 char    |
    |kategori    | yes       | no     | text          | 20 char    |
    |keyword     | yes       | no     | text          | 200 char   |
    |product_img | yes       | no     | webp,jpeg,png | 200kb      |
    |deskripsi   | yes       | no     | text          | 1000 char  |
    |linktp      | yes       | no     | text          | 200 char   |
    |linksp      | yes       | no     | text          | 200 char   |
    |linklz      | yes       | no     | text          | 200 char   |
    |linkwa      | yes       | no     | text          | 200 char   |
    |stock       | yes       | no     | num (1,0)     | 1          |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "add product is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`