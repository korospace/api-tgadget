# DELETE DATA ENDPOINT
<a href="../../README.md"><strong>« back to menu</strong></a>

<details open="open">
  <summary>Table of Contents</summary>
  <ul>
    <li><a href="#11-delete-product-category">delete product category</a></li>
    <li><a href="#12-delete-testimoni">delete testimoni</a></li>
    <li><a href="#13-delete-banner">delete banner</a></li>
    <li><a href="#14-delete-product">delete product</a></li>

  </ul>
</details>

## 1.1 delete product category
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/delete/category?id=:id
    ```
* **Request method** <br>
`DELETE`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params url** 

    | PARAMETER | REQUIRED | TYPE |
    | :--:      |  :--:    | :--: |
    |id         | yes      | yes  |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "delete categoriy with id ':id' is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.2 delete testimoni
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/delete/testimony?id=:id
    ```
* **Request method** <br>
`DELETE`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params url** 

    | PARAMETER | REQUIRED | TYPE |
    | :--:      |  :--:    | :--: |
    |id         | yes      | yes  |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "delete testimoni with id ':id' is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.3 delete banner
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/delete/banner?id=:id
    ```
* **Request method** <br>
`DELETE`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params url** 

    | PARAMETER | REQUIRED | TYPE |
    | :--:      |  :--:    | :--: |
    |id         | yes      | yes  |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "delete banner with id ':id' is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.4 delete product
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/delete/product?id=:id
    ```
* **Request method** <br>
`DELETE`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params url** 

    | PARAMETER | REQUIRED | TYPE |
    | :--:      |  :--:    | :--: |
    |id         | yes      | yes  |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "delete product with id ':id' is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`
