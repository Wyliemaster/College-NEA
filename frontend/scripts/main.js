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
