<?php
include "partials/header.php";

// Check if user is logged in
if(!isset($_SESSION['user-id'])) {
    // Redirect to login page or display an error message
    header("Location: " . ROOT_URL . "signin.php");
    exit();
}

// Fetch current user-id from session
$current_user_id = $_SESSION['user-id'];

// Use prepared statement to prevent SQL injection
$query = "SELECT id, title, author_id FROM notes WHERE author_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$notes = $stmt->get_result();

?>
<section class="dashboard">
    <!-- Alerts -->
    <?php if(isset($_SESSION['signin-success'])): ?>
    <div class="alert__message success container">
        <p><?=$_SESSION['signin-success']; unset($_SESSION['signin-success']); ?></p>
    </div>
    <?php elseif(isset($_SESSION['add-note'])): ?>
    <div class="alert__message error container">
        <p><?=$_SESSION['add-note']; unset($_SESSION['add-note']); ?></p>
    </div>
    <?php elseif(isset($_SESSION['add-note-success'])): ?>
    <div class="alert__message success container">
        <p><?=$_SESSION['add-note-success']; unset($_SESSION['add-note-success']); ?></p>
    </div>
    <?php elseif(isset($_SESSION['edit-note'])): ?>
    <div class="alert__message error container">
        <p><?=$_SESSION['edit-note']; unset($_SESSION['edit-note']); ?></p>
    </div>
    <?php elseif(isset($_SESSION['edit-note-success'])): ?>
    <div class="alert__message success container">
        <p><?=$_SESSION['edit-note-success']; unset($_SESSION['edit-note-success']); ?></p>
    </div>
    <?php endif ?>
    
    <!-- Dashboard Content -->
    <div class="container dashboard__container">
        <!-- Sidebar -->
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li><a href="<?= ROOT_URL ?>admin/add-note.php"><i class="uil uil-pen"></i><h5>Add note</h5></a></li>                
                <li><a href="<?= ROOT_URL ?>admin/index.php" class="active"><i class="uil uil-notecard"></i><h5>Manage notes</h5></a></li>
                <?php if(isset($_SESSION['user_is_admin'])): ?>
                <li><a href="<?= ROOT_URL ?>admin/add-user.php"><i class="uil uil-user-plus"></i><h5>Add User</h5></a></li>  
                <li><a href="<?= ROOT_URL ?>admin/manage-users.php"><i class="uil uil-users-alt"></i><h5>Manage Users</h5></a></li>
                <?php endif ?>
            </ul>
        </aside>
        
        <!-- Main Content -->
        <main>
            <h2>Manage notes</h2>
            <?php if(mysqli_num_rows($notes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>User</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($note = mysqli_fetch_assoc($notes)): ?>
                    <tr>
                        <td><?= $note['title'] ?></td>
                        <?php
                        // Fetch user name
                        $user_id = $note['author_id'];
                        $user_query = "SELECT firstname FROM users WHERE id = ?";
                        $stmt = $connection->prepare($user_query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $user_result = $stmt->get_result();
                        $user = mysqli_fetch_assoc($user_result);
                        ?>
                        <td><?= $user['firstname'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-note.php?id=<?= $note['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-note.php?id=<?= $note['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert__message error">No notes found</div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include "../partials/footer.php";
?>
