document.querySelector('select').addEventListener('change', function() {
    host = document.getElementById('host').innerHTML;
    username = document.getElementById('username').innerHTML;
    password = document.getElementById('password').innerHTML;
    database = document.getElementById('database-s').innerHTML;
    port = document.getElementById('port').innerHTML;
    hashData = document.getElementById('hash-data').checked;
    type = document.getElementById('type-database').innerHTML;
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
            hashData: hashData,
            type: type
        })
    }).then(response => response.json()).then(data => {
        document.getElementById('content').value = JSON.stringify(data.data, null, 4);
    });
});

document.getElementById('save').addEventListener('click', function() {
    host = document.getElementById('host').innerHTML;
    username = document.getElementById('username').innerHTML;
    password = document.getElementById('password').innerHTML;
    database = document.getElementById('database-s').innerHTML;
    port = document.getElementById('port').innerHTML;
    table = document.querySelector('select').value;
    content = document.getElementById('content').value;
    hashData = document.getElementById('hash-data').checked;
    type = document.getElementById('type-database').innerHTML;

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
            hashData: hashData,
            type: type
        })
    }).then(response => response.json()).then(data => {
        updated = data.updated;
        file = data.file;
        if (updated) {
            document.getElementById('alert').innerHTML = '<div class="alert alert-success" role="alert">Data updated successfully</div>';
        }
        if (file != '') {
            const fileUrlDownload = '/download.php?file=' + file;
            const fileName = file;
            const a = document.createElement('a');
            a.href = fileUrlDownload;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            const fileUrlDelete = '/delete.php?file=' + file;

            fetch(fileUrlDelete, { method: 'GET' }).then(response => response.text());
        }
    });
});

window.onload = function() {
    host = document.getElementById('host').innerHTML;
    username = document.getElementById('username').innerHTML;
    password = document.getElementById('password').innerHTML;
    database = document.getElementById('database-s').innerHTML;
    port = document.getElementById('port').innerHTML;
    type = document.getElementById('type-database').innerHTML;

    if (database == '') {
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
                port: port,
                type: type
            })
        }).then(response => response.json()).then(data => {
            document.getElementById('status-connect').innerHTML = data.connected ? '<div class="text-success">Connected</div>' : '<div class="text-danger">Not Connected</div>';
            document.getElementById('tables').innerHTML += data.tables.map(table => `<option value="${table}">${table}</option>`).join('');
        });
    }

    if (document.getElementById('type-database').innerHTML == '') {
        document.getElementById('alert').innerHTML = '<div class="alert alert-danger" role="alert">Please connect to a database first</div>';
    } else if (document.getElementById('type-database').innerHTML == 'mysql') {
        document.getElementById('mysql-status').hidden = false;
        if (document.getElementById('sqlite-status').hidden == false) {
            document.getElementById('sqlite-status').hidden = true;
        }
    } else if (document.getElementById('type-database').innerHTML == 'sqlite') {
        document.getElementById('sqlite-status').hidden = false;
        if (document.getElementById('mysql-status').hidden == false) {
            document.getElementById('mysql-status').hidden = true;
        }
    }
};