<!DOCTYPE html>
<html>

<head>
    <?php include 'add/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/account.css">
</head>

<body>
    <?php include 'add/nav.php'; ?>
    <div class="content">
        <div class='width-wrap'>
        
        <?php
            //CHECK SESSION IN HEADER
            if (!isset($_SESSION['user']['email'])) {
                header("Location: index.php");
                exit;
            } 
                
            include "db_connect.php";   
            $email = $_SESSION['user']['email'];
            consoleLog($email);
            
            //SQL DB FOR PW & ELECTIVE NAME
            $sql = 'SELECT
                        password,
                        electives.elective_name,
                    FROM 
                        users INNER JOIN electives ON users.elective = electives.elective
                    WHERE email = "'.$email.'"';
            consoleLog($sql);
            $result = mysqli_query($conn, $sql); 
            if (mysqli_num_rows($result) === 0){
                echo "Error: No data found in users table.";
            } else
            {
                $row = mysqli_fetch_assoc($result);
                $pw = $row['password'];
                $elective_name = $row['elective_name'];
            }  
            
            //CHECK INPUT & UPDATE (USERNAME)
            if (isset($_POST['user_name'])) {
                //UPDATE
                $new_name = $_POST['user_name'];
                $sql = 'UPDATE users SET name = "'.$new_name.'" WHERE email = "'.$email.'"';  
                consoleLog($sql);

                //CHECK IF SAVED IN DB
              if (mysqli_query($conn, $sql)) {
                  $_SESSION['user']['name'] = $new_name;
                  alert('Username updated');
                
              } else {
                alert('Error occurred: ".mysqli_error($conn)."');
              }
            }
            //CHECK INPUT & UPDATE (PASSWORD)
            if (
                isset($_POST['currentpw']) &&
                isset($_POST['newpw']) &&
                isset($_POST['confirmpw'])
            ) {
                $currentpw = sha1($_POST['currentpw']);
                if ($currentpw != $pw) {
                    alert('Current Password incorrect');    
                } else 
                {
                    if (($_POST['newpw']) != ($_POST['confirmpw'])) {
                        alert('New password does not match confirm password');  
                    } else {
                        $password = sha1($_POST['newpw']);
                        $sql = 'UPDATE users SET password = "'.$password.'" WHERE email = "'.$email.'"'; 
                        consoleLog($sql); // to check $sql
                        if (mysqli_query($conn, $sql)) {
                            $pw = $password;
                            alert('Password updated');
                          } else {
                            alert('Password not updated. Error occurred: ".mysqli_error($conn)."');
                          }
                    }
                }
            }
            //CHECK INPUT & UPDATE (COHORT)
            if (isset($_POST['user_cohort'])) 
            {
                $input_cohort = $_POST['user_cohort'];
                $sql = 'SELECT cohort FROM cohorts ';
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) 
                {
                    if (($row['cohort']) == $input_cohort)
                    {
                        $checkcohort = $row['cohort'];
                        $sql = 'UPDATE users 
                                SET cohort = "'.$input_cohort.'" 
                                WHERE email = "'.$email.'"';
                        consoleLog($sql); // to check $sql

                        //CHECK IF SAVED IN DB
                        if (mysqli_query($conn, $sql)) { 
                            $_SESSION['user']['cohort'] = $input_cohort;
                            alert('User cohort updated.');
                        } else { 
                            alert('User cohort not saved. Error occurred: ".mysqli_error($conn)."');
                        }
                    }
                } 
                if ($checkcohort == 0)
                    alert('Please enter valid cohort year.');
            }
            //CHECK INPUT & UPDATE (ELECTIVE)
            if (isset($_POST['user_elective'])) 
            {
                $input_elective = $_POST['user_elective'];
                $sql = "SELECT elective, elective_name FROM electives WHERE elective IS NOT NULL";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) 
                {
                    if (($row['elective']) == $input_elective)
                    {
                        $checkelective = $row['elective'];
                        $elective_name = $row['elective_name'];
                        $sql = 'UPDATE users 
                                SET elective = "'.$input_elective.'" 
                                WHERE email = "'.$email.'"';
                        consoleLog($sql); // to check $sql

                        //CHECK IF SAVED IN DB
                        if (mysqli_query($conn, $sql)) { 
                            $_SESSION['user']['elective'] = $input_elective;
                            alert('User elective updated.');
                        } else { 
                            alert('User elective not saved. Error occurred: ".mysqli_error($conn)."');
                        }
                    }
                } 
                if ($checkelective == 0)
                    alert('Please enter valid elective year.');
            }
            
            $name = $_SESSION['user']['name'];
            $cohort = $_SESSION['user']['cohort'];
            $elective = $_SESSION['user']['elective'];
            
        ?>
            <div class='inline'>
                <h1 class='named'><?php echo $name; ?></h1>
                <form class='namer' action='account.php' method='post'>
                    <input type='text' value='<?php echo $name; ?>' name='user_name' required>
                    <input type='submit' value='Update'>
                </form>
            </div> 
            <span style=' font-size: 15pt; font-weight: 550;  text-transform: uppercase; cursor: pointer; display: inline-block;text-decoration: underline; color: #f6b93b; text-decoration-color: #B90628' id='namer-toggle'>Edit</span>
            <br><br>
            <h3>
                <table>
                <tr>
                    <td >email</td>
                    <td style="padding-left: 10px"> :</td>
                    <td style="padding-left: 10px"> <?php echo $email; ?> </td>
                </tr>
                <tr>
                    <td>password</td>
                    <td style="padding-left: 10px"> :</td>
                    <td style="padding-left: 10px"> 
                        
                        <span style='font-size: 15pt; font-weight: 550;  text-transform: uppercase; cursor: pointer; display: inline-block;text-decoration: underline; color: #f6b93b; text-decoration-color: #B90628' id='changepw-toggle'>Change Password</span> 
                        <form class='changepw' action='account.php' method='post'>
                            <table> 
                                <tr>
                                    <td><label>Current Password</label></td>
                                    <td style="padding-left: 10px"> : </td>
                                    <td style="padding-left: 10px" ><input type='password' name='currentpw' required></td>
                                </tr>
                                <tr>
                                    <td><label>New Password</label></td>
                                    <td style="padding-left: 10px"> : </td>
                                    <td style="padding-left: 10px"><input type='password' name='newpw' required></td>
                                </tr>
                                    <br>
                                <tr>
                                    <td><label>Confirm Password</label></td>
                                    <td style="padding-left: 10px"> : </td>
                                    <td style="padding-left: 10px"><input type='password' name='confirmpw' required></td>
                                </tr>
                            </table>
                            <br>
                            <input type='submit' value='Change Password'> 
                        </form>
                    </td>
                </tr>
                    <tr><td><br></td></tr>
                    <br>
                   
                <tr>
                    <td>cohort</td>
                    <td style="padding-left: 10px"> :</td>
                    <td style="padding-left: 10px"> 
                        <?php 
                        if ($cohort === null)
                        { 
                            echo "No cohort!";?>

                        <span style='font-size: 15pt; font-weight: 550;  text-transform: uppercase; cursor: pointer; display: inline-block;text-decoration: underline; color: #f6b93b; text-decoration-color: #B90628' id='cohort-toggle'>Add Cohort</span>
                        <br>
                    
                        <form class='cohort' action='account.php' method='post'>
                                    <input type='text' value='YYYY' name='user_cohort' required>
                                    <input type='submit' value='Add Cohort'>
                                </form>
                        <?php 
                        }else {
                            echo $cohort;
                        } ?> 
                    </td>
                </tr>
                <tr>
                    <td>elective</td>
                    <td style="padding-left: 10px"> :</td>
                    <td style="padding-left: 10px"> 
                        <?php 
                        if ($cohort === null)
                         echo "Select cohort first!";
                        else
                        {
                            if ($elective === null)
                            { 
                                echo "No elective!";?>
                                <form class='electiveadd' action='account.php' method='post'>
                                    <br>
                                    <input type='text' name='user_elective' required>
                                    <input type='submit' value='Add Elective'> <br>
                                    <a> <br>ECAL: Electrical and Systems Engineering
                                        <br>ENIC: Electronic Engineering
                                        <br>INON: Info-Communication Engineering<br>
                                        <br>
                                    </a>
                                </form>
                                <span style='font-size: 15pt; font-weight: 550;  text-transform: uppercase;cursor: pointer; display: inline-block;text-decoration: underline; color: #f6b93b; text-decoration-color: #B90628' id='electiveadd-toggle'>Add Elective</span>
                            <?php 
                            } else 
                            {
                                echo $elective;
                            ?>
                                <form class='elective' action='account.php' method='post'>
                                        <br>
                                        <input type='text' name='user_elective' required>
                                        <input type='submit' value='Edit Elective'>
                                        <a> <br>ECAL: Electrical and Systems Engineering
                                            <br>ENIC: Electronic Engineering
                                            <br>INON: Info-Communication Engineering<br>
                                            <br>
                                        </a>
                                    </form>
                                    <span style='font-size: 15pt; font-weight: 550;  text-transform: uppercase; cursor: pointer; display: inline-block;text-decoration: underline; color: #f6b93b; text-decoration-color: #B90628' id='elective-toggle'>Edit</span>
                            <?php }} ?>
                    </td>
                </tr>
            </table>
            </h3>
            
            <button id='logout'>Log out</button>
            
            <h2>History</h2>
            
                        
            
            
        
                
        </div>
    </div>
    <?php var_dump($_SESSION['user']);include 'add/footer.php'; ?>
</body>

<script>
    
    $(document).ready(function() {
        $('#electiveadd-toggle').click(function() {
            let current = $(this).text();
            $(this).text(current == 'Add Elective' ? 'Cancel' : 'Add Elective');
            if ($('.changepw').is(":visible")) $('#changepw-toggle').click();
            if ($('.namer').is(":visible")) $('#namer-toggle').click();
            if ($('.cohort').is(":visible")) $('#cohort-toggle').click();
            $('.electiveadd').toggle();
        });
        $('#elective-toggle').click(function() {
            let current = $(this).text();
            $(this).text(current == 'Edit' ? 'Cancel' : 'Edit'); 
            if ($('.changepw').is(":visible")) $('#changepw-toggle').click();
            if ($('.cohort').is(":visible")) $('#cohort-toggle').click();
            if ($('.namer').is(":visible")) $('#namer-toggle').click();
            $('.elective').toggle();
        });
        $('#cohort-toggle').click(function() {
            let current = $(this).text();
            $(this).text(current == 'Add Cohort' ? 'Cancel' : 'Add Cohort');
            if ($('.changepw').is(":visible")) $('#changepw-toggle').click();
            if ($('.elective').is(":visible")) $('#elective-toggle').click();
            if ($('.namer').is(":visible")) $('#namer-toggle').click();
            $('.cohort').toggle();
        });
        $('#changepw-toggle').click(function() {
            let current = $(this).text();
            $(this).text(current == 'Change Password' ? 'Cancel' : 'Change Password');
            if ($('.electiveadd').is(":visible")){ $('#electiveadd-toggle').click();};
            if ($('.elective').is(":visible")){ $('#elective-toggle').click();};
            if ($('.cohort').is(":visible")) {$('#cohort-toggle').click();};
            if ($('.namer').is(":visible")) {$('#namer-toggle').click();};
            $('.changepw').toggle();
        });
        $('#namer-toggle').click(function() {
            let current = $(this).text();
            $(this).text(current == 'Edit' ? 'Cancel' : 'Edit');
            if ($('.changepw').is(":visible")) $('#changepw-toggle').click();
            if ($('.electiveadd').is(":visible")){ $('#electiveadd-toggle').click();};
            if ($('.cohort').is(":visible")) {$('#cohort-toggle').click();};
            $('.namer').toggle();
            $('.named').toggle();
        });
        $('#logout').click(function() {
            $.ajax({
                url: 'account/logout.php',
                type: 'GET',
                success: function() {
                    window.location.href = "index.php";
                }
            });
        });
    });
</script>

</html>