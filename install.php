<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_db') {
        $host = $_POST['db_host'] ?? 'localhost';
        $user = $_POST['db_user'] ?? 'root';
        $pass = $_POST['db_pass'] ?? '';
        $dbname = $_POST['db_name'] ?? 'marketplace';
        
        $conn = new mysqli($host, $user, $pass);
        
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
            exit;
        }
        
        // Create database
        $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
        $conn->select_db($dbname);
        
        // Create tables
        $sql_file = file_get_contents('sql/schema.sql');
        $queries = array_filter(array_map('trim', explode(';', $sql_file)));
        
        foreach ($queries as $query) {
            if (!empty($query)) {
                if (!$conn->query($query)) {
                    echo json_encode(['success' => false, 'message' => 'Query Error: ' . $conn->error]);
                    exit;
                }
            }
        }
        
        // Save .env
        $env_content = "DB_HOST=$host\nDB_USER=$user\nDB_PASS=$pass\nDB_NAME=$dbname\nAPP_URL=http://\$_SERVER['HTTP_HOST']\n";
        file_put_contents('.env', $env_content);
        
        echo json_encode(['success' => true, 'message' => 'Database created successfully']);
        exit;
    }
    
    if ($action === 'create_admin') {
        require_once 'core/Database.php';
        require_once 'core/Auth.php';
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? 'Admin';
        
        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Email and password required']);
            exit;
        }
        
        $db = new Database();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        if ($db->query("INSERT INTO users (email, password, name, role) VALUES ('$email', '$hash', '$name', 'admin')")) {
            echo json_encode(['success' => true, 'message' => 'Admin created successfully']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create admin']);
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Installation - Digital Marketplace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }
        .container { max-width: 600px; margin: 50px auto; background: white; padding: 40px; border-radius: 8px; }
        h1 { margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .message { margin-top: 20px; padding: 15px; border-radius: 4px; display: none; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .step { display: none; }
        .step.active { display: block; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Digital Marketplace Installation</h1>
        
        <div class="step active" id="step1">
            <h2>Step 1: Database Configuration</h2>
            <div class="form-group">
                <label>Database Host:</label>
                <input type="text" id="db_host" value="localhost">
            </div>
            <div class="form-group">
                <label>Database User:</label>
                <input type="text" id="db_user" value="root">
            </div>
            <div class="form-group">
                <label>Database Password:</label>
                <input type="password" id="db_pass">
            </div>
            <div class="form-group">
                <label>Database Name:</label>
                <input type="text" id="db_name" value="marketplace">
            </div>
            <button onclick="setupDB()">Create Database</button>
            <div class="message" id="msg1"></div>
        </div>
        
        <div class="step" id="step2">
            <h2>Step 2: Create Admin Account</h2>
            <div class="form-group">
                <label>Admin Email:</label>
                <input type="email" id="admin_email">
            </div>
            <div class="form-group">
                <label>Admin Password:</label>
                <input type="password" id="admin_password">
            </div>
            <div class="form-group">
                <label>Admin Name:</label>
                <input type="text" id="admin_name" value="Administrator">
            </div>
            <button onclick="createAdmin()">Create Admin</button>
            <div class="message" id="msg2"></div>
        </div>
    </div>
    
    <script>
        function setupDB() {
            const data = new FormData();
            data.append('action', 'create_db');
            data.append('db_host', document.getElementById('db_host').value);
            data.append('db_user', document.getElementById('db_user').value);
            data.append('db_pass', document.getElementById('db_pass').value);
            data.append('db_name', document.getElementById('db_name').value);
            
            fetch('install.php', { method: 'POST', body: data })
                .then(r => r.json())
                .then(r => {
                    const msg = document.getElementById('msg1');
                    msg.className = 'message ' + (r.success ? 'success' : 'error');
                    msg.textContent = r.message;
                    msg.style.display = 'block';
                    
                    if (r.success) {
                        setTimeout(() => {
                            document.getElementById('step1').classList.remove('active');
                            document.getElementById('step2').classList.add('active');
                        }, 1500);
                    }
                });
        }
        
        function createAdmin() {
            const data = new FormData();
            data.append('action', 'create_admin');
            data.append('email', document.getElementById('admin_email').value);
            data.append('password', document.getElementById('admin_password').value);
            data.append('name', document.getElementById('admin_name').value);
            
            fetch('install.php', { method: 'POST', body: data })
                .then(r => r.json())
                .then(r => {
                    const msg = document.getElementById('msg2');
                    msg.className = 'message ' + (r.success ? 'success' : 'error');
                    msg.textContent = r.message;
                    msg.style.display = 'block';
                    
                    if (r.success) {
                        setTimeout(() => {
                            window.location.href = '/admin/login.php';
                        }, 1500);
                    }
                });
        }
    </script>
</body>
</html>
