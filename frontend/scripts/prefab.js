let prefab_index = 0;

async function fetch_prefab(name, id)
{
    const response = await fetch(`./frontend/prefab/${name}.prefab`);

    if (response.status != 200) return null;

    let data = await response.text();

    return data.replace(/\[\[PREFAB_ID\]\]/gm, id++);
}

/*
 Fetches a prefab element and injects it into the webpage via a parent

 @name - the name of the prefab
 @parent - the parent to attatch the DOM elemnt to
 @settings - Object containing replacements to default variables
*/
async function add_prefab(name, parent, settings, id = prefab_index++)
{
    let prefab = await fetch_prefab(name, id);

    if (prefab != null)
    {

        for (const key in settings) {            
            prefab = prefab.replace(key, settings[key]);
        }
        
        document.getElementById(parent).innerHTML += prefab;
    }
}

function show_prefab_element(element_name)
{
    prefab = document.getElementById(`prefab-${element_name}`);

    prefab.style.scale = 1;
    prefab.style.visibility = "visible";
}

function hide_prefab_element(element_name)
{
    prefab = document.getElementById(`prefab-${element_name}`);

    prefab.style.scale = 0;
    prefab.style.visibility = "hidden";
}

