<?php 
include 'layout-default.php'; 

$host = $_POST['host'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$database = $_POST['database-m'] ?? '';
if ($database === '') {
    $database = $_FILES['database-s']['tmp_name'] ?? '';
    if ($database !== '') {
        $file = $_FILES['database-s'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileDestination = 'uploads/' . $fileName;
        move_uploaded_file($fileTmpName, $fileDestination) ? $database = $fileDestination : $database = '';
    }
}
$port = $_POST['port'] ?? '';
$type = $_POST['type-mysql'] ?? '';
if ($type === '') $type = $_POST['type-sqlite'] ?? '';
$tables = [];
?>
<body>
    <div class="container">
        <?php include 'header.php'; ?>
        <div id="alert"></div>
        <div id="status-connect" class="mt-3 text-center"></div>
        <div class="mt-3 text-center">
            <b>Type Database:&nbsp;</b><div id="type-database"><?php echo $type ?></div>
        </div>
        <div id="mysql-status" class="d-flex mt-3" style="justify-content: center;">
            <b>Host:&nbsp;</b><div id="host"><?php echo $host ?></div>&nbsp;&nbsp;
            <b>Username:&nbsp;</b><div id="username"><?php echo $username ?></div>&nbsp;&nbsp;
            <b>Password:&nbsp;</b><div id="password"><?php echo $password ?></div>&nbsp;&nbsp;
            <b>Database:&nbsp;</b><div id="database"><?php echo $database ?></div>&nbsp;&nbsp;
            <b>Port:&nbsp;</b><div id="port"><?php echo $port ?></div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <select id="tables" class="form-select bg-secondary text-white" aria-label="tables">
                    <option selected hidden>Select Table</option>
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="hash-data">
                    <label class="form-check-label" for="hash-data">
                        Is your data hashed?
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <select id="set-sizes" class="form-select bg-secondary ms-auto text-white" aria-label="set-sizes" style="width: 6%;">
                    <option selected hidden>15</option>
                    <?php for ($i = 1; $i <= 100; $i++) { ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div>
            <div id="code"></div><br>
            <button id="save" type="button" class="btn btn-success">Save Changes</button>
        </div>
    </div>
</body>
<script src="public/js/edit-page.js"></script>
<?php include 'footer.php'; ?>