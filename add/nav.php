<?php session_start(); include "account/login.php"; ?>
<nav style="position:fixed; top:0;">
        <!---->
        <!-- SHOW LINKS -->
        <a href="guide.php">Guide</a>
        <a href="link.php">Links</a>
    
    <!--CHECK SESSION FOR PLAN-->
    <?php
        if (
            isset($_SESSION['user']['email']))
        {   //IF SESSION EXIST,
            echo "<a href='plan.php'>Plan</a>";
        }
        else
        {   //ELSE SHOW SIGN UP OR LOGIN OPTION
            echo "<a href='#' class='show-modal'>Plan (Users Only)</a>";
        }
    ?>     
            
    <a href="resources.php">Resources</a>

    <!--CHECK SESSION FOR LOGIN/ACCOUNT-->
    <?php
    if (isset($_SESSION['user']['email']))
        {   //IF SESSION EXIST, SHOW ACCOUNT
            echo "<a href='account.php'>Account</a>";
        }
        else
        {   //ELSE SHOW LOGIN OPTION
            echo "<a href='#' class='show-modal'>Log In</a>";
        }
        ?> 
</nav>
    
<!--MODAL BOX POPUP-->
<div class="modal">
        <div class="box">
            <div class="x"></div>
            <!--SHOW LOGIN/SIGNUP OPTIONS-->
            <span id="show-login" class="current">Log In</span> | 
            <span id="show-signup">Sign Up</span>
            <!-- LOGIN/SIGNUP FORM-->
            <form class="login" method="post" action="index.php">
                <label>Email</label>
                <input type="text" name="email" required>@e.ntu.edu.sg
                <label>Password</label>
                <input type="password" name="password" required>
                <input type="submit" value="Log in"> 
            </form>
            <form class="signup" method="post" action="index.php">
                <label>Email</label>
                <input type="text" name="email" required>
                <label>Name</label>
                <input type="text" name="name" required>
                <label>Password</label>
                <input type="password" name="password" required>
                <label>Enter password again</label>
                <input type="password" name="password2" required>
                <input type="submit" value="Sign Up"> 
            </form>
        </div>
    </div>

<!--JS FOR SIGNUP-->
<script>
        $(document).ready(function() {
            //SHOW SIGNUP
            $('#show-signup').click(function() {
                $('#show-login').removeClass('current');
                $(this).addClass('current');
                $('.login').hide(); //HIDE LOGIN
                $('.signup').show(); //SHOW SIGNUP
            });
            //SHOW LOGIN
            $('#show-login').click(function() {
                $('#show-signup').removeClass('current');
                $(this).addClass('current');
                $('.signup').hide();//HIDE SIGNUP
                $('.login').show(); //SHOW LOGIN
            });
            //SHOW X BUTTON TO CLOSE
            $('.x').click(function() {
                $('.modal').fadeOut(200);
            });
            //SHOW BOX
            $('.show-modal').click(function() {
                $('.modal').fadeIn(200);
            })
        })
    </script>