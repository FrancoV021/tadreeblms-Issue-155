<!DOCTYPE html>
<html>
<head>
    <title>Installer</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #f9f9f9; }
        .box { width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        button { padding: 12px 25px; background:#4CAF50; color:white; border:none; border-radius:8px; cursor:pointer; }
        pre { background: #222; color:#0f0; padding:15px; height:300px; overflow:auto; }
    </style>
</head>
<body>

<div class="box">
    <h2>Laravel Installer</h2>
    <p>Click button to install your application automatically.</p>

    <button onclick="runInstall()">Start Installation</button>

    <pre id="output"></pre>
</div>

<script>
function runInstall() {
    document.getElementById('output').innerHTML = "Running installation...\n";

    fetch('/install/run', { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
        .then(r => r.json())
        .then(data => {
            document.getElementById('output').innerText = data.logs;
        });
}
</script>

</body>
</html>
