let prefab_index = 0;

async function fetch_prefab(name)
{
    const response = await fetch(`./frontend/prefab/${name}.prefab`);
    let data = await response.text();

    return data.replace(/\[\[PREFAB_ID\]\]/gm, prefab_index++);
}

/*
 @name - the name of the prefab
 @parent - the parent to attatch the DOM elemnt to
 @settings - Object containing replacements to default variables
*/
async function load_prefab(name, parent, settings)
{
    let prefab = await fetch_prefab(name);

    for (const key in settings) {
        console.log(key, settings[key])

        prefab = prefab.replace(key, settings[key]);
    }

    document.getElementById(parent).innerHTML = prefab;

}