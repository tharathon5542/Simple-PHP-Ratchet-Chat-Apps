<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broken Chat App</title>
</head>

<body>
    <textarea name="chatbox" id="chatbox" cols="50" rows="10" style="resize: none;" readonly></textarea> <br><br>
    <input type="text" id="name" value="" placeholder="Name">
    <input type="text" id="message" value="" placeholder="Message">
    <button onclick="sendMessage(document.getElementById('message').value)">Send</button>
</body>
<script>
    var conn = new WebSocket('ws://localhost:8089');

    conn.onopen = function(e) {
        console.log("Connection established!");
        document.getElementById("chatbox").value += "Connection established!" + '\r\n';
    };

    conn.onmessage = function(e) {
        writeMessage(e.data);
        document.getElementById("chatbox").scrollTop = document.getElementById("chatbox").scrollHeight;
    };

    document.getElementById('message').addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            sendMessage(document.getElementById('message').value);
        }
    });

    function writeMessage(message) {
        document.getElementById("chatbox").value += message + '\r\n';
    }

    function sendMessage(message) {
        if (document.getElementById("name").value !== '' && message !== '') {
            fullMessage = document.getElementById("name").value + ' : ' + message;
            conn.send(fullMessage);
            writeMessage(fullMessage);
            document.getElementById("chatbox").scrollTop = document.getElementById("chatbox").scrollHeight;
            document.getElementById('message').value = '';
            document.getElementById('message').focus();
        } else {
            alert('Please Enter Name and Messaage');
        }
    }
</script>

</html>