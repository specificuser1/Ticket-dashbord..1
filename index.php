<?php
require "config.php";
$settings = json_decode(file_get_contents("settings.json"), true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Bot Dashboard</title>
    <style>
        body { background:#0e0e0e; color:white; font-family:Arial; text-align:center; }
        input, select { padding:10px; margin:5px; width:300px; }
        button { padding:12px 20px; background:#4CAF50; color:white; border:none; }
        .card { background:#1b1b1b; padding:20px; width:400px; margin:auto; border-radius:8px; }
    </style>
</head>
<body>

<h1>Ticket Bot Dashboard</h1>

<div class="card">
    <h3>Update Settings</h3>

    <input id="ticket_category" type="text" value="<?= $settings['ticket_category'] ?>" placeholder="Ticket Category ID"><br>
    <input id="staff_role" type="text" value="<?= $settings['staff_role'] ?>" placeholder="Staff Role ID"><br>

    <select id="transcripts">
        <option value="true" <?= $settings["transcripts"] ? "selected" : "" ?>>Transcripts: ON</option>
        <option value="false" <?= !$settings["transcripts"] ? "selected" : "" ?>>Transcripts: OFF</option>
    </select><br><br>

    <button onclick="save()">Save Settings</button>
</div>

<script>
function save() {
    fetch("api/update-settings.php", {
        method: "POST",
        headers: { "Content-Type": "application/json", "API-KEY": "YOUR_SECRET_KEY" },
        body: JSON.stringify({
            ticket_category: document.getElementById("ticket_category").value,
            staff_role: document.getElementById("staff_role").value,
            transcripts: document.getElementById("transcripts").value === "true"
        })
    }).then(r => r.json())
      .then(res => alert("Settings Updated!"));
}
</script>

</body>
</html>
