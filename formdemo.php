<!-- form_select.php -->
<form method="POST" action="generate_pdf.php">
    <label for="user_id">Select User ID:</label>
    <select name="user_id" id="user_id">
        <!-- Fetch user IDs from the database -->
        <?php
        require_once 'connection.php'; // Database connection
        
        // Get the list of users (assuming a users table with an 'id' column)
        $query = "SELECT id, firstname, lastname FROM registrations";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['firstname'] . " " . $row['lastname'] . "</option>";
            }
        } else {
            echo "<option>No users found</option>";
        }
        ?>
    </select>
    <button type="submit">Generate PDF</button>
</form>
