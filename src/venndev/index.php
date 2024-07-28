<?php include 'layout-default.php'; ?>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <main class="container mt-5 mb-5">
            <div class="mt-5">
                <h1 class="text-center">Choose Database</h1>
            </div>
            <div class="d-flex justify-content-center mt-5">
                <button id="bnt-login-mysql" class="btn btn-primary">MySQL</button>
                &nbsp;
                <button id="bnt-login-sqlite" class="btn btn-primary">SQLite</button>
            </div>
            <div class="mt-5">
                <form id="mysql-login" action="edit-page.php" method="post" enctype="multipart/form-data" style="width: 50%; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px;" hidden>
                    <h2>MySQL</h2>
                    <div class="form-group mt-3" hidden>
                        <label for="type-mysql" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type-mysql" name="type-mysql" value="mysql" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="host" class="form-label">Host</label>
                        <input type="text" class="form-control" id="host" name="host" value="localhost" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="root" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group mt-3">
                        <label for="database-m" class="form-label">Database</label>
                        <input type="text" class="form-control" id="database-m" name="database-m" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="port" class="form-label">Port</label>
                        <input type="number" class="form-control" id="port" name="port" value="3306" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
                <form id="sqlite-login" action="edit-page.php" method="post" enctype="multipart/form-data" style="width: 50%; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px;" hidden>
                    <h2>SQLite</h2>
                    <div class="form-group mt-3" hidden>
                        <label for="type-sqlite" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type-sqlite" name="type-sqlite" value="sqlite" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="database-s" class="form-label">Database</label>
                        <input type="file" class="form-control" id="database-s" name="database-s" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </main>
    </div>
</body>
<script>
    document.getElementById('bnt-login-mysql').addEventListener('click', function() {
        document.getElementById('mysql-login').hidden = false;
        document.getElementById('bnt-login-mysql').classList.remove('btn-primary');
        document.getElementById('bnt-login-mysql').classList.add('btn-secondary');
        if (document.getElementById('bnt-login-sqlite').classList.contains('btn-secondary')) {
            document.getElementById('bnt-login-sqlite').classList.remove('btn-secondary');
            document.getElementById('bnt-login-sqlite').classList.add('btn-primary');
        }
        if (document.getElementById('sqlite-login').hidden == false) {
            document.getElementById('sqlite-login').hidden = true;
        }
    });
    document.getElementById('bnt-login-sqlite').addEventListener('click', function() {
        document.getElementById('sqlite-login').hidden = false;
        document.getElementById('bnt-login-sqlite').classList.remove('btn-primary');
        document.getElementById('bnt-login-sqlite').classList.add('btn-secondary');
        if (document.getElementById('bnt-login-mysql').classList.contains('btn-secondary')) {
            document.getElementById('bnt-login-mysql').classList.remove('btn-secondary');
            document.getElementById('bnt-login-mysql').classList.add('btn-primary');
        }
        if (document.getElementById('mysql-login').hidden == false) {
            document.getElementById('mysql-login').hidden = true;
        }
    });
</script>
<?php include 'footer.php'; ?>