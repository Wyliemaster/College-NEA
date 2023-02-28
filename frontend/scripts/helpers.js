// creates register popup
function show_register_popup() {
  show_prefab_element("popup-background-0");
  show_prefab_element("popup-0");
}
// shows login popup
function show_login_popup() {
  show_prefab_element("popup-background-1");
  show_prefab_element("popup-1");
}
// Loads all main page prefabs into the webpage
function load_main_page_prefabs() {
  let register = `<form action="./API/v1/register.php"  method="post">
    <label for="uname">Username</label><br>
    <input type="text" id="uname" name="uname" placeholder="user123..."><br>
    <label for="pass">Password</label><br>
    <input type="password" id="pass" name="pass" placeholder="**********"><br><br>
    <input type="submit" value="Submit">
  </form> `;

  let login = `<form action="./API/v1/login.php"  method="post">
    <label for="uname">Username</label><br>
    <input type="text" id="uname" name="uname" placeholder="user123..."><br>
    <label for="pass">Password</label><br>
    <input type="password" id="pass" name="pass" placeholder="**********"><br><br>
    <input type="submit" value="Submit">
  </form> `;


let upload = `<form action="./API/v1/upload_code.php"  method="get">
<label for="title">Title</label><br>
<input type="text" id="title" name="title" placeholder="Title..."><br>

<label for="desc">Description</label><br>
<input type="text" id="desc" name="desc" placeholder="description"><br>

<label for="code">code</label><br>
<textarea name="code" id="code"></textarea><br><br>

<input type="submit" value="Submit">
</form> `;



  add_prefab(
    "popup",
    "Prefabs",
    {
      "[[POPUP_TITLE]]": "Register",
      "[[POPUP_DESC]]": "Use this form to create an account",
      "[[POPUP_CONTAINER]]": register,
    },
    0
  );

  add_prefab(
    "popup",
    "Prefabs",
    {
      "[[POPUP_TITLE]]": "Login",
      "[[POPUP_DESC]]": "Use this form to Login to your account",
      "[[POPUP_CONTAINER]]": login,
    },
    1
  );

  add_prefab(
    "popup",
    "Prefabs",
    {
      "[[POPUP_TITLE]]": `Upload`,
      "[[POPUP_DESC]]": "Explain what your code does in the forms below",
      "[[POPUP_CONTAINER]]": upload,
    },
    2
  );

}
// loads all the content page prefabs into the webpage
function load_content_page_prefabs() {
  let register = `<form action="../API/v1/register.php"  method="post">
      <label for="uname">Username</label><br>
      <input type="text" id="uname" name="uname" placeholder="user123..."><br>
      <label for="pass">Password</label><br>
      <input type="password" id="pass" name="pass" placeholder="**********"><br><br>
      <input type="submit" value="Submit">
    </form> `;

  let login = `<form action="../API/v1/login.php"  method="post">
      <label for="uname">Username</label><br>
      <input type="text" id="uname" name="uname" placeholder="user123..."><br>
      <label for="pass">Password</label><br>
      <input type="password" id="pass" name="pass" placeholder="**********"><br><br>
      <input type="submit" value="Submit">
    </form> `;

  add_prefab(
    "popup",
    "Prefabs",
    {
      "[[POPUP_TITLE]]": "Register",
      "[[POPUP_DESC]]": "Use this form to create an account",
      "[[POPUP_CONTAINER]]": register,
    },
    0,
    "../"
  );

  add_prefab(
    "popup",
    "Prefabs",
    {
      "[[POPUP_TITLE]]": "Login",
      "[[POPUP_DESC]]": "Use this form to Login to your account",
      "[[POPUP_CONTAINER]]": login,
    },
    1,
    "../"
  );
}
// Logs the user out
async function logout(start = "") {
  await fetch(`${start}./API/v1/logout.php`);
  location.reload();
}
// creates upload code popup
function upload_code()
{
        show_prefab_element("popup-background-2");
        show_prefab_element("popup-2");
}