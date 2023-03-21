let cache = [];

async function get_content(filter, user) {
  let str = "";
  console.log(filter);
  const response = await fetch(`../API/v1/content.php?filter=${filter}&user=${user}`);

  // if the request fails, return null
  if (response.status != 200) return null;

  let data = await response.json();

  cache = data;

  // add a prefab for each element
  for (let index = 0; index < data.length; index++) {
    const element = data[index];

    console.log(element)
    let container = `<pre style="background-color:grey; padding: 20px; border: 1px red solid; overflow-y: hidden; max-height: 200px; font-size: small;" onclick="open_content(${index})">${element["content_code"]}</pre>`;
    str += `<a class="user-content-btn" onclick="more_details(${index})">${element["content_title"]}</a>`;
    add_prefab(
      "popup",
      "details_prefab",
      {
        "[[POPUP_TITLE]]": `${element["content_title"]} <img src=/NEA/Assets/like_00${element["rating_id"] ? 2 : 1}.png style="width:25px; height:25px; cursor: pointer;" onclick="like(${element["content_id"]})">`,
        "[[POPUP_DESC]]": element["content_description"],
        "[[POPUP_CONTAINER]]": container,
      },
      100 + index,
      "../"
    );
  }
  // inject string into container
  document.getElementById("user-content-container").innerHTML = str;
}

async function more_details(id) {
  show_prefab_element(`popup-background-${100 + id}`);
  show_prefab_element(`popup-${100 + id}`);
}

async function open_content(id) {
  window.location.replace(`/NEA/?default=${encodeURIComponent(cache[id]["content_code"])}`);
}

async function like(id)
{
  const response = await fetch(`../API/v1/like.php`, {
    method: "POST",
    body: new URLSearchParams({id: id}),
  });



}