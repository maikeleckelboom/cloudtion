<?php
$accmgr->requireLoggedOut();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_message = $accmgr->login($_POST['email'], $_POST['password']);
}

$redirect = 'dashboard';
if (isset($_GET['redirect'])) {
    $redirect = base64_decode($_GET['redirect']);
}

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
    <title>Cloudtion | Login</title>
</head>
<body class="login">

<div class="grid-container">
    <div class="cloudtion-entry">
        <div class="cell auto">

            <div class="top-row">
                <h1>Cloudtion | Inloggen</h1>
                <?php if (isset($_GET['logout'])): ?>
                    <span>Je bent nu uitgelogd.</span>
                <?php elseif (isset($_GET['logout_error'])): ?>
                    <span>Je bent uitgelogd door een fout in het systeem.</span>
                <?php elseif (isset($_GET['pass_change'])): ?>
                    <span>Je wachtwoord is veranderd.</span>
                <?php elseif (isset($_GET['logout_pass'])): ?>
                    <span>Je bent uitgelogd door een verandering in je wachtwoord. Komt dit niet door jou? Neem dan zo snel mogelijk contact op met een administrator.</span>
                <?php elseif (isset($_GET['redirect'])): ?>
                    <span>Je moet eerst inloggen om deze pagina (<?= $redirect ?>) te kunnen bekijken. Je word omgeleid zodra je bent ingelogd.</span>
                <?php elseif (isset($_GET['not_logged_in'])): ?>
                    <span>Je kan niet uitloggen als je niet bent ingelogd &#128579;.</span>
                <?php elseif (isset($_GET['register_complete'])): ?>
                    <span>Je account is aangemaakt. Om in te kunnen loggen moet je eerst je e-mailadres verifiëren. Dit doe je door naar je inbox te gaan en je e-mails te controleren. Volg dan de instrucies op die in de e-mail staan.<br /><br />Het kan even duren voordat de e-mail binnenkomt. Controleer zo af en toe ook je spam folder.</span>
                <?php elseif (isset($_GET['email_verified'])): ?>
                    <span>Je e-mailadres is geverifieerd. Je kan nu inloggen.</span>
                <?php elseif (isset($_GET['email_not_verified'])): ?>
                    <span>Je e-mailadres kon niet worden geverifieerd. Neem contact op met een administrator.</span>
                <?php elseif (isset($login_message)): ?>
                    <span><?= $login_message ?></span>
                <?php endif; ?>
            </div>

            <form method="post" action="login" class="login-form" id="loginForm">
                <div class="grid-x grid-margin-x form-division">

                    <div class="cell small-24 form-group">
                        <label for="lastname">E-mailadres</label>
                        <input type="text"
                            placeholder="E-mailadres"
                            id="email"
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
                        <button type="submit" name="login" class="login-button">
                            <span>Inloggen</span>
                            <svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1">
                                <path style="fill:none;stroke-width: 1px;stroke: #fff;"
                                      d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <div class="form-group">
                <span class="entry-actions">
                    Nog geen account?
                    <a href="register" class="button-secondary">Registreren</a>
                </span>
            </div>

        </div>
    </div>
</div>


<?php include "includes/clouds.php"; ?>

<script>
    $(document).ready(function () {
        // Validator
        new Validator(document.querySelector('#loginForm'), function(err, res) {
            return res;
        });
        // Button
        let spinnerButton;
        return spinnerButton = new SpinnerButton($(".login-button"), () => {
            $('#loginForm').submit();
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