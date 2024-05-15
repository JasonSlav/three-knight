<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalasi Aplikasi</title>
</head>

<body style="text-align: center;">
    <h1>Instalasi Aplikasi Tahap 2</h1>
    <p>Copy path dibawah ini, lalu buka folder sesuai path yang telah di copy.<br>
     Setelah itu, buka zip yang telah didownload, lalu buka folder src, dan ekstrak isi folder itu kedalam folder htdocs tadi.<br>
     NOTE: ABAIKAN ISI ZIP SELAIN FOLDER "src" DAN ISINYA!</p>
    <input type="text" value="C:\xampp\htdocs" id="myInput">
    <button onclick="myFunction()">Copy text</button>

    <p>Setelah melakukan ekstrak, silahkan klik tombol dibawah ini.</p>
    <a href="index.php">Lanjut...</a>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);

            alert("Copied the text: " + copyText.value);
        }
    </script>
</body>