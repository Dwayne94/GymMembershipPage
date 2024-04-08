<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Membership Database</title>
    <link rel = "stylesheet" href = "GymHome2.css">
</head>
<body>
    <header>
        <h1>Gym Membership Database</h1>
    </header>

    <?php
    //Provide the servername, username, password
    $servername = "localhost";
    $username = "root";
    $password = "Blueoystercult94#";

    //Provide the database to be used
    $database = "db_prac";

    //Create the connection 
    $connection = new mysqli($servername, $username, $password, $database);

    //Check the connection
    if($connection->connect_error)
    {
        die ("Server connection was unsuccessful".$connection->connect_error);
    }
    else 
    {
        echo "Server has been connected successfully";
    }

    echo "<br>";

    //Since the database is already created, directly connecting. 
    if($connection->select_db($database)===TRUE)
    {
        echo "Database db_prac is selected successfully";
    }
    else
    {
        die ("Database db_prac was not selected successfully. Please try again.".$connection->error);
    }

    echo "<br>";

    //Create the Table for Gym Members registering as New Members
    $tbl_gymmembers = "create table tbl_gymmembers(FirstName varchar(30) not null, LastName varchar(30) not null, DateofBirth date not null, Gender varchar(20), MembershipType varchar(25) not null, Email varchar(40) not null, Username varchar(40) not null, Password varchar(25) not null)";

    //Check if the Table is created 
    if($connection->query($tbl_gymmembers)===TRUE)
    {
        echo "Table tbl_gymmembers is created successfully";
    }
    else
    {
        die ("Unable to create Table tbl_gymmembers. Please try again!".$connection->error);
    }

    //Fetch the records entered on the web page
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $dob = $_POST['birthdate'];
    $gender = $_POST['sex'];
    $membertype = $_POST['membertype'];
    $email = $_POST['email'];
    $usname = $_POST['uname'];
    $password = $_POST['pword'];

    //Once the details are fetched, we need to insert the details into the table 
    $insert = "insert into tbl_gymmembers values ('$firstname', '$lastname', '$dob', '$gender', '$membertype', '$email', '$usname', '$password')";

    //Check if the data was inserted into the table 
    if($connection->query($insert)===TRUE)
    {
        echo "New Gym Member has been added successfully.";
    }
    else 
    {
        die ("Unable to add the Member record to the Table tbl_gymmembers. Please try again!"$connection->error);
    }

    //Once the data is entered into the table, we need to display the table
    $display = "select * from tbl_gymmembers";

    //Check whether the details are displayed correctly on the table 
    $result = $connection->query($display);

    //Check if the Table displays more than 0 rows
    if($result->num_rows>0)
    {
        //Create a Table
        echo "<table>";
        //Create a Row for the Table. tr stands for table row
        echo "<tr>";
        //Create the Table Headings - th stands for table header
        echo "<th>Full Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Date of Birth</th>";
        echo "<th>Gender</th>";
        echo "<th>Membership Type</th>";
        echo "<th>Email</th>";
        echo "<th>Username</th>";
        echo "<th>Password</th>";
        // Add update and delete buttons
        echo "<td><form action='update_member.php' method='post'><input type='hidden' name='id' value='".$row["id"]."'><button type='submit'>Update</button></form></td>";
        echo "<td><form action='delete_member.php' method='post'><input type='hidden' name='id' value='".$row["id"]."'><button type='submit'>Delete</button></form></td>";
        echo "</tr>";

        echo "<br>";

        while($row = $result->fetch_assoc())
        {
            //Create a Row for the Table to add each record
            echo "<tr>";
            //Add the Data in that row for every column - td stands for table data
            echo "<td>".$row["First Name"]."</td>";
            echo "<td>".$row["Last Name"]."</td>";
            echo "<td>".$row["Date of Birth"]."</td>";
            echo "<td>".$row["Gender"]."</td>";
            echo "<td>".$row["Membership Type"]."</td>";
            echo "<td>".$row["Email"]."</td>";
            echo "<td>".$row["Username"]."</td>";
            echo "<td>".$row["Password"]."</td>";
            echo "</tr>";
        }
    }
    else
    {
        die ("All the records not displayed correctly. Please display the table again.".$result->error);
    }

    // Check if the form for updating member details is submitted
    if(isset($_POST['update'])) 
    {
    // Retrieve form data
    $id = $_POST['id'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $dob = $_POST['birthdate'];
    $gender = $_POST['sex'];
    $membertype = $_POST['membertype'];
    $email = $_POST['email'];
    $usname = $_POST['uname'];
    $password = $_POST['pword'];

    // SQL query to update member details
    $update_query = "UPDATE tbl_gymmembers SET FirstName='$firstname', LastName='$lastname', DateofBirth='$dob', Gender='$gender', MembershipType='$membertype', Email='$email', Username='$usname', Password='$password' WHERE id=$id";

    // Execute the update query
    if ($connection->query($update_query) === TRUE) {
        echo "Member details updated successfully.";
    } else {
        echo "Error updating member details: " . $connection->error;
    }
}

// Check if the form for deleting a member is submitted
if(isset($_POST['delete'])) 
{
    // Retrieve member ID to delete
    $id = $_POST['id'];

    // SQL query to delete member
    $delete_query = "DELETE FROM tbl_gymmembers WHERE id=$id";

    // Execute the delete query
    if ($connection->query($delete_query) === TRUE) {
        echo "Member deleted successfully.";
    } else {
        echo "Error deleting member: " . $connection->error;
    }
}

    ?>

</body>
</html>