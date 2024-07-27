<?php include 'layout-default.php'; ?>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <main class="container mt-5 mb-5">
            <form action="edit-page.php" method="post" enctype="multipart/form-data" style="width: 50%; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
                <h2>Login Database</h2>
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
                    <label for="database" class="form-label">Database</label>
                    <input type="text" class="form-control" id="database" name="database" required>
                </div>
                <div class="form-group mt-3">
                    <label for="port" class="form-label">Port</label>
                    <input type="number" class="form-control" id="port" name="port" value="3306" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Login</button>
            </form>
        </main>
    </div>
</body>
<?php include 'footer.php'; ?>