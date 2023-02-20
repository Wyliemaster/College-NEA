
async function decompile_assembly()
{
    let code = document.getElementById("input").innerText;

    let data = {
        code: code,
        type: "1530",
    };

    const response = await fetch("./API/v1/decompile.php", {
        method: "POST",
        body: new URLSearchParams(data)
    });

    let text =  await response.text();

    document.getElementById("output").innerHTML = text;


}

function upload_file()
{
    document.getElementById("upload-file").click();
    document.getElementById("upload-file").addEventListener("change", decompile_file, false);
}


async function decompile_file() {

    let reader = new FileReader();
    
    reader.readAsText(this.files[0]);

    reader.onload = async function(e)
    {
        let data = {
            code: reader.result,
            type: "2167",
        };
        
        const response = await fetch("./API/v1/decompile.php", {
            method: "POST",
            body: new URLSearchParams(data)
        });
    
        let text = await response.text();

        console.log(text);
    
        document.getElementById("output").innerHTML = text;
    }


  }