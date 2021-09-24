<p align="center">
  <a href="https://github.com/korospace/t-gadgetapi">
    <img src="sub-readme/api-logo.webp" alt="Logo" width="120">
  </a>

  <h1 align="center">T-Gadgetid restful api</h1>

  <p align="center">
    This is my first restful api which I made using php native. The purpose of this api is make it easier for me to manage the content on the t-gadget.herokuapp.com.
    <br />
    <br />
  </p>
</p>

## Tools & Stack
- [x] PHP Native (MVC)
- [x] firebase/php-jwt
- [x] phpmailer
- [x] rakit validation
- [x] mysql

## Endpoints <br>
- to get the api-key, user must register a new account
- api-key and token are obtained every time the user logs in
- public api-key: `610644b1eba3e` <br>
  **use this api-key if you only need data retrieval* <br>
- url structure: <br>
  ```
  https://t-gadgetapi.herokuapp.com/:controller/:method
  ```
- url previx: <br>
  ```
  https://t-gadgetcors.herokuapp.com/https://t-gadgetapi.herokuapp.com/:controller/:method
  ```
  **use this prefix to avoid blocked by CORS*
- endpoints:

  | CONTROLLER | METHOD | AUTH   | DETAIL USAGE |
  | :--:       |  :---  |  :--:  |  :--:        |
  | /user   | <ul><li>/register</li><li>/login</li><li>/session</li><li>/edit</li><li>/logout</li><li>/delete</li></ul> | `api-key` `token`| <a href="/sub-readme/user-activities/README.md">detail</a>
  | /get    | <ul><li>/socialmedia</li><li>/countdown</li><li>/banners</li><li>/testimonies</li><li>/statistics</li><li>/categories</li><li>/keywords</li><li>/products</li></ul>  | `api-key` | <a href="/sub-readme/get-data/README.md">detail</a>
  | /add    | <ul><li>/category</li><li>/banenr</li><li>/testimoni</li><li>/product</li></ul> | `api-key` `token` | <a href="/sub-readme/add-data/README.md">detail</a>
  | /update | <ul><li>/socialmedia</li><li>/countdown</li><li>/product</li><li>/statistic</li></ul> | `api-key` `token`   | <a href="sub-readme/update-data/README.md">detail</a>
  | /delete | <ul><li>/category</li><li>/banner</li><li>/testimoni</li><li>/product</li></ul> | `api-key` `token`   | <a href="/sub-readme/delete-data/README.md">detail</a>