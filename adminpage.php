
<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit;
}

// Path to the JSON file
$jsonFile = 'projects.json';

// Load existing projects
$projects = [];
if (file_exists($jsonFile)) {
    $data = file_get_contents($jsonFile);
    $projects = json_decode($data, true)['projects'];
}

// Handle form submission for adding a project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $newProject = [
        "image" => $_POST['image'],
        "category" => $_POST['category'],
        "github_link" => $_POST['github_link']
    ];

    // Add the new project
    $projects[] = $newProject;

    // Save back to JSON
    file_put_contents($jsonFile, json_encode(['projects' => $projects], JSON_PRETTY_PRINT));

    $success = "Project added successfully!";
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_project'])) {
    $index = $_POST['index'];

    // Remove the project at the specified index
    array_splice($projects, $index, 1);

    // Save back to JSON
    file_put_contents($jsonFile, json_encode(['projects' => $projects], JSON_PRETTY_PRINT));

    $success = "Project deleted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="adminpage.css" rel="stylesheet">
</head>
<body>
<header>
        <nav>
            <ul>
           <h1>💗Welcome <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
        <button type="submit" name="logout"style="color:#fff; background-color:#6f42c1;margin-top: -5px; ;">Logout</button>
    </form>            
                
            </ul>
        </nav>
    </header>    
    <?php if (isset($success)) { ?>
        <p class="success"><?php echo $success; ?></p>
    <?php } ?>
<div class="section">
<form method="POST">
    <h2>Add New Project</h2>
        <div class="form-group">
            <label for="image">Image URL:</label>
            <input type="text" id="image" name="image" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="first">Web Design</option>
                <option value="second">Web Development</option>
                <option value="thred">Apps Development</option>
            </select>
        </div>
        <div class="form-group">
            <label for="github_link">GitHub Link:</label>
            <input type="text" id="github_link" name="github_link" required>
        </div>
        <button type="submit" name="add_project">Add Project</button>
    </form>

</div>
  

    <h2>Existing Projects</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Category</th>
                <th>GitHub Link</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $index => $project) { ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><img src="<?php echo htmlspecialchars($project['image']); ?>" alt="Project Image" style="width: 100px;"></td>
                    <td><?php echo htmlspecialchars($project['category']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($project['github_link']); ?>" target="_blank"><?php echo htmlspecialchars($project['github_link']); ?></a></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button style="background:#ff4a4a;color: #fff;" type="submit" name="delete_project" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
