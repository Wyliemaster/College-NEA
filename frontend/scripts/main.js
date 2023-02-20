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

    if (text == -1)
    {

        document.getElementById("output").innerHTML = "DECOMPILATION ERROR";
        return;
    }

    document.getElementById("output").innerHTML = text;


}
