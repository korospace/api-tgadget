# UPDATE DATA ENDPOINT
<a href="../../README.md"><strong>« back to menu</strong></a>

<details open="open">
  <summary>Table of Contents</summary>
  <ul>
    <li><a href="#11-update-socialmedia">update socialmedia</a></li>
    <li><a href="#12-update-countdown">update countdown</a></li>
    <li><a href="#13-update-product">update product</a></li>
    <li><a href="#14-update-statistic">update statistic</a></li>
  </ul>
</details>

## 1.1 update socialmedia
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/update/socialmedia
    ```
* **Request method** <br>
`PUT`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 

    | PARAMETER     | REQUIRED | TYPE | MAX_LENGTH |
    | :--:          |  :--:    | :--: | :--:       |
    |link_tokopedia | yes      | text | 250 char   |
    |link_shopee    | yes      | text | 250 char   |
    |link_lazada    | yes      | text | 250 char   |
    |link_whatsapp  | yes      | text | 250 char   |
    |link_ourwebsite| yes      | text | 250 char   |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "update socialmedia is success" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.2 update countdown
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/update/countdown
    ```
* **Request method** <br>
`PUT`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 

    | PARAMETER | REQUIRED | TYPE         | MIN_MAX_LENGTH |
    | :--:      |  :--:    | :--:         | :--:           |
    |day        | yes      | num (dd)     | 2              |
    |month      | yes      | num (mm)     | 2              |
    |year       | yes      | num (yyyy)   | 4              |
    |poster     | opsional | webp,jpeg,png| 200kb          |

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "update countdown is success!" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.3 update product
* **URL** <br>
    ```
    https://t-gadgetapi.herokuapp.com/update/product
    ```
* **Request method** <br>
`PUT`
* **Request header** 
  - api-key  <br>
  - token  <br>
* **Params body** 
  
    | PARAMETER  | REQUIRED  | UNIQUE | TYPE          | MAX_LENGTH |
    | :--:       |  :--:     |  :--:  |  :--:         | :--:       |
    |product_id  | yes       | yes    | text          | -          |
    |product_name| yes       | yes    | text          | 250 char   |
    |price       | yes       | no     | num           | 11 char    |
    |kategori    | yes       | no     | text          | 20 char    |
    |keyword     | yes       | no     | text          | 200 char   |
    |product_img | -         | no     | webp,jpeg,png | 200kb      |
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
        "message": "update product with id :id is success" 
      }
      ```
* **Error Response:**
    * **code :** 400 Bad Request<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 401 Unauthorized<br />
      **json :** `{ "success": false,"message": {} }` <br/>
    * **code :** 404 Not found<br />
      **json :** `{ "success": false,"message": "product with id :id is not found" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`

## 1.4 update statistic
* **URL** <br>
  
  | Detail Target | url    | value  |
  | :--        |  :-- |  :-- |
  | update product viewers | /update/statistics?productid=:id   |**your product id* |
  | update store visitors  | /update/statistics?storename=:name | `tokopedia` `shopee`<br>`lazada` `whatsapp`<br>`ourwebsite` |
  | update store visitors at specific product  | /update/statistics?productid=:id&storename=:name | `productid` `storename` |

* **Request method** <br>
`PUT`
* **Request header** 
  - api-key  <br>

* **Success response**
    * **code :** 201 Created<br />
      **json :** 
      ```
      { 
        "success": true,
        "message": "success update .."
      }
      ```
* **Error Response:**
    * **code :** 404 Not Found<br />
      **json :** `{ "success": false,"message": "" }` <br/>
    * **code :** 500 Internal Server Error<br />
      **json :** `{ "success": false,"message": "" }`
