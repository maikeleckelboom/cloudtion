<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register_result = $accmgr->register($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['passwordVal']);
}

$accmgr->requireLoggedOut();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/vendor/jquery.js"></script>
    <link rel="icon" href="files/cloud.svg" type="image/png" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="foundation/css/foundation.min.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <title>Cloudtion | Register</title>
</head>
<body class="register">

<div class="grid-container">
    <div class="cloudtion-entry">
        <div class="cell auto">

            <div class="top-row">
                <h1>Cloudtion | Registreren</h1>
                <?php if (isset($register_result)): ?>
                    <span><?= $register_result ?></span>
                <?php endif; ?>
            </div>

            <form method="post" action="register" class="register-form" id="registerForm">
                <div class="grid-x grid-margin-x form-division">

                    <div class="cell small-12 form-group">
                        <label for="firstname" >Voornaam</label>
                        <input type="text"
                            placeholder="Voornaam"
                            id="firstname"
                            autocomplete="off"
                            name="firstname"
                            <?php if (isset($_POST['firstname'])): ?>
                            value="<?= $_POST['firstname'] ?>"
                            <?php endif; ?>
                            data-rule="required|firstname">
                    </div>

                    <div class="cell small-12 form-group">
                        <label for="lastname">Achternaam</label>
                        <input type="text"
                            placeholder="Achternaam"
                            id="lastname"
                            autocomplete="off"
                            name="lastname"
                            <?php if (isset($_POST['lastname'])): ?>
                            value="<?= $_POST['lastname'] ?>"
                            <?php endif; ?>
                            data-rule="required|lastname">
                    </div>

                    <div class="cell small-24 form-group">
                        <label for="email">E-mailadres</label>
                        <input type="email"
                            placeholder="E-mailadres"
                            id="email"
                            autocomplete="off"
                            name="email"
                            <?php if (isset($_POST['email'])): ?>
                            value="<?= $_POST['email'] ?>"
                            <?php endif; ?>
                            data-rule="required|email">
                    </div>

                    <div class="cell small-24 form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password"
                            placeholder="Wachtwoord"
                            id="password"
                            name="password"
                            data-rule="required|password">
                    </div>

                    <div class="cell small-24 form-group">
                        <label for="repeat-password">Herhaal wachtwoord</label>
                        <input type="password"
                            placeholder="Herhaal wachtwoord"
                            id="repeat-password"
                            autocomplete="off"
                            name="passwordVal"
                            data-rule="required|passwordVal">
                    </div>


                    <div class="cell small-9 form-group">
                        <div class="form-group">
                           <span class="reset">
                                <input type="reset" value="Begin opnieuw" class="reset">
                                <img src="files/resetsmall.png" class="icon">
                            </span>
                        </div>
                    </div>

                    <div class="cell small-15">
                        <div class="form-group">
                            <button type="submit" class="register-button">
                                <span>Registreren</span>
                                <svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1">
                                    <path style="fill:none;stroke-width: 1px;stroke: #fff;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <div class="form-group">
                <span class="entry-actions">
                    Al een account?
                    <a href="login" class="button-secondary">Inloggen</a>
                </span>
            </div>

        </div>
    </div>
</div>


<?php include "includes/clouds.php"; ?>

<script>
    $(document).ready(function () {
        // Validator
        new Validator(document.querySelector('#registerForm'), function(err, res) {
            return res;
        });

        // Button
        let spinnerButton;
        return spinnerButton = new SpinnerButton($(".register-button"), () => {
            $('#registerForm').submit();
        });

    });
</script>
<script src="js/vendor/js-form-validator/js-form-validator.js"></script>
<script src="foundation/js/vendor/what-input.js"></script>
<script src="foundation/js/vendor/foundation.min.js"></script>
<script src="foundation/js/app.js"></script>
<script src="js/loadingbar.js"></script>
<script src="js/app.js"></script>
</body>
</html>