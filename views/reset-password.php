<?php

$resetting_with_key = (isset($_GET['a']) && isset($_GET['t']));
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$accmgr->currentUser) {
        if ($resetting_with_key) {
            $reset_message = $accmgr->changeUserPasswordWithKey($_GET['t'], $_GET['a'], $_POST['new_password'], $_POST['new_password_validate']);
        } else {
            $reset_message = $accmgr->forgotPassword($_POST['email']);
        }
    } else {
        $reset_message = $accmgr->changeCurrentUserPassword($_POST['current_password'], $_POST['new_password'], $_POST['new_password_validate']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/vendor/jquery.js"></script>
    <link rel="icon" href="files/cloud3.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="foundation/css/foundation.min.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <title>Cloudtion | Wachtwoord <?= $accmgr->currentUser ? 'Veranderen' : 'Vergeten' ?></title>
</head>
<body class="login">

<div class="grid-container">
    <div class="cloudtion-entry">
        <div class="cell auto">

            <div class="top-row">
                <h1>Cloudtion | Wachtwoord <?= $accmgr->currentUser ? 'Veranderen' : 'Vergeten' ?></h1>
                <?php if (isset($reset_message)): ?>
                    <span><?= $reset_message ?></span>
                <?php elseif (isset($_GET['request_complete'])): ?>
                    <span>
                        Er is een link naar je e-mailadres verstuurd waarmee je je wachtwoord kan veranderen.
                        Geen e-mail ontvangen? Kijk in je spam-folder of wacht een paar minuten. De link is 30 minuten geldig.
                    </span>
                <?php endif; ?>
            </div>

            <?php if (!isset($_GET['request_complete'])): ?>

            <form method="post" action="#" class="reset-password-form" id="resetPasswordForm">
                <div class="grid-x grid-margin-x form-division">

                    <?php if ($accmgr->currentUser): ?>

                    <div class="cell small-24 form-group">
                        <label for="current_password">Huidig wachtwoord</label>
                        <input type="password"
                            placeholder="Huidig wachtwoord"
                            id="current_password"
                            name="current_password"
                            data-rule="required|password">
                    </div>
                    
                    <?php elseif (!$resetting_with_key): ?>

                    <div class="cell small-24 form-group">
                        <label for="lastname">E-mailadres</label>
                        <input type="text"
                            placeholder="E-mailadres"
                            id="email"
                            name="email"
                            data-rule="required|email">
                    </div>

                    <?php endif; ?>
                    <?php if ($accmgr->currentUser || $resetting_with_key): ?>

                    <div class="cell small-24 form-group">
                        <label for="new_password">Nieuw wachtwoord</label>
                        <input type="password"
                               placeholder="Nieuw wachtwoord"
                               id="new_password"
                               name="new_password"
                               data-rule="required|password">
                    </div>

                    <div class="cell small-24 form-group">
                        <label for="new_password_validate">Herhaal nieuw wachtwoord</label>
                        <input type="password"
                               placeholder="Herhaal nieuw wachtwoord"
                               id="new_password_validate"
                               name="new_password_validate"
                               data-rule="required|password">
                    </div>

                    <?php endif; ?>

                    <div class="cell small-24 form-group">
                        <button type="submit" name="change_password" class="login-button">
                            <span>Ga verder</span>
                            <svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1">
                                <path style="fill:none;stroke-width: 1px;stroke: #fff;"
                                      d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <?php endif; ?>

            <div class="form-group">
                <span class="entry-actions">
                    <?php if (!$accmgr->currentUser): ?>
                    <a href="login" class="button-secondary">Inloggen</a>
                    <?php else: ?>
                    <a href="dashboard" class="button-secondary">Dashboard</a>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</div>


<?php include "includes/clouds.php"; ?>

<script type="text/javascript" src="js/vendor/js-form-validator/js-form-validator.js"></script>
<script>
    // Validator
    new Validator(document.querySelector('#resetPasswordForm'), (err, res) => {
        return res;
    });

    // Spinner button
    $(document).ready(function () {
        let spinnerButton;
        return spinnerButton = new SpinnerButton($("button"), () => {
            $('#resetPasswordForm').submit();
        });
    });
</script>
<script src="foundation/js/vendor/what-input.js"></script>
<script src="foundation/js/vendor/foundation.min.js"></script>
<script src="foundation/js/app.js"></script>
<script src="js/loadingbar.js"></script>
<script src="js/app.js"></script>
</body>
</html>