<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="js/script.js" defer></script>
</head>

<body>
    <div id="header">
        <h1>Subscribe for free and become a Hero !</h1>
    </div>
    <div id="form-container">
        <form action="router.php" method="post">
            <div class="info-container">
                <?php
                if(isset($_SESSION['msg'])){
                    echo($_SESSION['msg']);
                }
                ?>
                <p id="generalInfo"></p>
            </div>
            <div class="input-container">
                <label for="firstname">Firstname :</label>
                <input type="text" name="firstname" id="firstname" required>
            </div>
            <div class="info-container">
                <label for="firstname" id="firstnameInfo"></label>
            </div>
            <div class="input-container">
                <label for="lastname">Lastname :</label>
                <input type="text" name="lastname" id="lastname" required>
            </div>
            <div class="info-container">
                <label for="lastname" id="lastnameInfo"></label>
            </div>
            <div class="input-container">
                <label for="gender">Gender: </label>
                <input type="radio" name="gender" value="male" checked>Male</input>
                <input type="radio" name="gender" value="female">Female</input>
            </div>
            <div class="input-container">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="info-container">
                <label for="email" id="emailInfo"></label>
            </div>
            <div class="input-container">
                <label for="birth">Birthdate :</label>
                <input type="date" name="birth" id="birth" required>
            </div>
            <div class="info-container">
                <label for="birth" id="birthInfo"></label>
            </div>
            <div class="input-container">
                <label for="phone">Phone Number :</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <div class="info-container">
                <label for="phone" id="phoneInfo"></label>
            </div>
            <div class="input-container">
                <label for="country">Country :</label>
                <input type="text" name="country" id="country" required>
            </div>
            <div class="info-container">
                <label for="country" id="countryInfo"></label>
            </div>
            <div class="input-container">
                <label for="question">Question :</label>
                <textarea name="question" id="question" minlength="15" required></textarea>
            </div>
            <div class="info-container">
                <label for="question" id="questionInfo"></label>
            </div>
            <div class="input-container">
                <button id="submit">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>