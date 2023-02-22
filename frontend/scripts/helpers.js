function show_register_popup() {
  show_prefab_element("popup-background-0");
  show_prefab_element("popup-0");
}

function show_login_popup() {
    show_prefab_element("popup-background-1");
    show_prefab_element("popup-1");
  }

function load_main_page_prefabs() {
  let register = `<form action="./API/v1/register.php">
    <label for="uname">Username</label><br>
    <input type="text" id="uname" name="uname" placeholder="user123..."><br>
    <label for="pass">Password</label><br>
    <input type="password" id="pass" name="pass" placeholder="**********"><br><br>
    <input type="submit" value="Submit">
  </form> `;

  let login = `<form action="./API/v1/login.php">
    <label for="uname">Username</label><br>
    <input type="text" id="uname" name="uname" placeholder="user123..."><br>
    <label for="pass">Password</label><br>
    <input type="password" id="pass" name="pass" placeholder="**********"><br><br>
    <input type="submit" value="Submit">
  </form> `;


  add_prefab("popup", "Prefabs", {
    "[[POPUP_TITLE]]": "Register",
    "[[POPUP_DESC]]": "Use this form to create an account",
    "[[POPUP_CONTAINER]]": register,
  }, 0);

  add_prefab("popup", "Prefabs", {
    "[[POPUP_TITLE]]": "Login",
    "[[POPUP_DESC]]": "Use this form to Login to your account",
    "[[POPUP_CONTAINER]]": login,
  }, 1);
}
