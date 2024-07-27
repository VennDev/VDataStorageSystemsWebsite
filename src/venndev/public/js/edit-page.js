document.querySelector('select').addEventListener('change', function() {
    host = document.getElementById('host').innerHTML;
    username = document.getElementById('username').innerHTML;
    password = document.getElementById('password').innerHTML;
    database = document.getElementById('database').innerHTML;
    port = document.getElementById('port').innerHTML;
    hashData = document.getElementById('hash-data').checked;
    table = this.value;

    fetch('action/get-content-table.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            host: host,
            username: username,
            password: password,
            database: database,
            port: port,
            table: table,
            hashData: hashData
        })
    }).then(response => response.json()).then(data => {
        document.getElementById('content').value = JSON.stringify(data.data, null, 4);
    });
});

document.getElementById('save').addEventListener('click', function() {
    host = document.getElementById('host').innerHTML;
    username = document.getElementById('username').innerHTML;
    password = document.getElementById('password').innerHTML;
    database = document.getElementById('database').innerHTML;
    port = document.getElementById('port').innerHTML;
    table = document.querySelector('select').value;
    content = document.getElementById('content').value;
    hashData = document.getElementById('hash-data').checked;

    fetch('action/save.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            host: host,
            username: username,
            password: password,
            database: database,
            port: port,
            table: table,
            content: content,
            hashData: hashData
        })
    }).then(response => response.json()).then(data => {
        updated = data.updated;
        if (updated) {
            document.getElementById('alert').innerHTML = '<div class="alert alert-success" role="alert">Data updated successfully</div>';
        }
    });
});

window.onload = function() {
    host = document.getElementById('host').innerHTML;
    username = document.getElementById('username').innerHTML;
    password = document.getElementById('password').innerHTML;
    database = document.getElementById('database').innerHTML;
    port = document.getElementById('port').innerHTML;

    if (host == '' || username == '' || database == '' || port == '') {
        window.location.href = 'index.php';
    } else {
        fetch('action/get-tables.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                host: host,
                username: username,
                password: password,
                database: database,
                port: port
            })
        }).then(response => response.json()).then(data => {
            document.getElementById('status-connect').innerHTML = data.connected ? '<div class="text-success">Connected</div>' : '<div class="text-danger">Not Connected</div>';
            document.getElementById('tables').innerHTML += data.tables.map(table => `<option value="${table}">${table}</option>`).join('');
        });
    }
};