<?php
require "config.php";
$settings = json_decode(file_get_contents("settings.json"), true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ticket Bot Dashboard</title>
<style>
    body {
        background:url('https://4kwallpapers.com/images/walls/thumbs_3t/25454.jpg') no-repeat center center fixed;
        background-size:cover;
        font-family:Poppins,Arial;
        color:white;
        margin:0;
        padding:40px;
    }
    .glass {
        backdrop-filter:blur(14px);
        background:rgba(255,255,255,0.12);
        padding:25px;
        width:500px;
        margin:auto;
        border-radius:20px;
        box-shadow:0 10px 40px rgba(0,0,0,0.4);
    }
    input, select {
        width:90%; padding:10px; margin:10px 0;
        border-radius:10px; border:none; outline:none;
    }
    button {
        padding:12px 20px; border-radius:10px;
        border:none; background:#00c6ff; color:white;
        cursor:pointer; margin:10px; font-size:15px;
    }
    button:hover { background:#0095cc; }
    .online { color:#00ff85; }
    .offline { color:#ff4545; }
</style>
</head>
<body>

<div class="glass">
    <h2>Ticket Bot Dashboard</h2>

    <p>Bot Status: <span id="status">Checking...</span></p>

    <h3>Categories</h3>

    <div id="cats">
        <?php foreach ($settings["categories"] as $c): ?>
            <div>
                <input value="<?= $c['id'] ?>" placeholder="Category ID">
                <input value="<?= $c['name'] ?>" placeholder="Category Name">
            </div>
        <?php endforeach; ?>
    </div>

    <button onclick="addCat()">+ Add Category</button>

    <h3>Staff Role</h3>
    <input id="staff_role" value="<?= $settings['staff_role'] ?>">

    <h3>Ticket Panel Embed</h3>
    <input id="embed_title" value="<?= $settings['ticket_panel_message']['title'] ?>" placeholder="Title">
    <input id="embed_desc" value="<?= $settings['ticket_panel_message']['description'] ?>" placeholder="Description">

    <button onclick="save()">Save</button>
    <button onclick="panel()">Send Panel</button>
</div>

<script>
function addCat() {
    document.getElementById("cats").innerHTML += `
    <div>
        <input placeholder="Category ID">
        <input placeholder="Category Name">
    </div>`;
}

// SAVE SETTINGS
function save() {
    let list = [];
    document.querySelectorAll("#cats div").forEach(d => {
        let i = d.querySelectorAll("input");
        list.push({ id: i[0].value, name: i[1].value });
    });

    fetch("api/update-settings.php", {
        method: "POST",
        headers: { "Content-Type":"application/json", "API-KEY":"YOUR_SECRET_KEY" },
        body: JSON.stringify({
            categories: list,
            staff_role: document.getElementById("staff_role").value,
            transcripts: true,
            ticket_panel_message: {
                title: document.getElementById("embed_title").value,
                description: document.getElementById("embed_desc").value
            }
        })
    }).then(r=>r.json()).then(x=>alert("Saved!"));
}

// SEND TICKET PANEL
function panel() {
    fetch("api/create-panel.php", {
        method:"POST",
        headers:{ "API-KEY":"YOUR_SECRET_KEY" }
    }).then(r=>r.json()).then(x=>alert("Panel Sent to Discord!"));
}

// STATUS POLL
setInterval(()=>{
    fetch("api/bot-status.php")
        .then(r=>r.json())
        .then(x=>{
            document.getElementById("status").innerHTML =
                x.online ? "<span class='online'>Online</span>" : "<span class='offline'>Offline</span>";
        });
},2000);
</script>

</body>
</html>
