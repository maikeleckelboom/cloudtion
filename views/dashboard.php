<?php
$accmgr->requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "includes/head.php" ?>
    <title>Cloudtion | Dashboard</title>
</head>
<body class="dashboard">

<!-- Modal Create -->
<div id="modalCreate"
     class="reveal"
     data-reveal
     data-ajax-url="views/includes/modals/create.php"
     data-close-on-click="false"
     data-close-on-esc="true"
     closable>
</div>

<!-- Modal Deletee -->
<div id="modalDelete"
     class="reveal"
     data-reveal
     data-ajax-url="views/includes/modals/delete.php"
     data-close-on-click="false"
     data-close-on-esc="true"
     closable>
</div>

<!-- Modal Reset -->
<div id="modalReset"
     class="reveal"
     data-reveal
     data-ajax-url="views/includes/modals/reset.php"
     data-close-on-click="false"
     data-close-on-esc="true"
     closable>
</div>

<div class="grid-container">

    <div class="grid-x top-section">

        <div class="cell small-12 medium-8 cloudtion">
            <div class="logo-container">
                <span>Cloudtion<b> | Dashboard</b></span>
            </div>
        </div>

        <div class="cell small-24 medium-8 page-title">
<!--            <div class="title-container">-->
<!--                <span>Studenten Server Management</span>-->
<!--            </div>-->
        </div>

        <div class="cell small-12 medium-8 user-menu">
            <div class="dropdown-container">
                <div class="button drop-button" id="droptrigger">
                    <span>
                        <span id="user_name"><?= $accmgr->currentUser->first_name ?>&nbsp;<?= $accmgr->currentUser->last_name ?></span>
                        <?php include "files/angle-down.html" ?>
                    </span>
                </div>
                <div class="dropcontent">
                    <a href="logout" class="drop-anchor">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img src="files/logout.svg" class="logout-icon">
                                <span>Uitloggen</span>
                            </li>
                        </ul>
                    </a>
                </div>
            </div>
        </div>

    </div>


    <div class="grid-x grid-margin-x grid-margin-y">

        <div class="cell small-24 medium-12 large-16 callout">
            <p>
                Welkom in de Cloudtion omgeving. Dit is de plek waar je jouw persoonlijke servers kunt opzetten.
                Deze servers worden gekoppeld aan je student nummer en toegewezen via een gekozen gebruikersnaam en
                wachtwoord.
            </p>
        </div>

        <div class="cell small-24 medium-12 large-8">
            <div class="entry-group">
                <img src="files/cloud-server.svg">
                <p>
                    Maak een nieuwe server
                </p>
                <div class="button-container">
                    <a id="" href="#modalCreate" data-open="modalCreate">
                        <span>Nieuwe server</span>
                        <img src="files/add-plus-button.svg" class="plus-icon">
                    </a>
                </div>
            </div>
        </div>

        <div class="cell small-24 large-24">
            <div class="table-container">
                <table class="server-table transform">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Server ID</th>
                        <th>Verwijder</th>
                        <th>Reset</th>
                        <th>Start / Stop</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <img src="files/ok.png" class="status">
                            <span class="label stat-data">Running</span>
                        </td>
                        <td>
                            <span>Linux Server N3</span>
                        </td>
                        <td>
                            <span>129293845c422</span>
                        </td>
                        <td>
                            <a href="#modalDelete" data-open="modalDelete" class="button action-btn">
                                <span>Verwijderen</span>
                            </a>
                        </td>
                        <td>
                            <a href="#modalReset" data-open="modalReset" class="button action-btn">
                                <span>Reset</span>
                            </a>
                        </td>
                        <td>
                                <span class="button action-btn stopServer" disabled>
                                    <span>Stop</span>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="files/ok.png" class="status">
                            <span class="label stat-data">Running</span>
                        </td>
                        <td>
                            <span>Centos Linux N4</span>
                        </td>
                        <td>
                            <span>129293845c422</span>
                        </td>
                        <td>
                                <span class="button action-btn deleteServer">
                                    <span>Verwijderen</span>
                                </span>
                        </td>
                        <td>
                                <span class="button action-btn resetServer">
                                    <span>Reset</span>
                                </span>
                        </td>
                        <td>
                                <span class="button action-btn stopServer" disabled>
                                    <span>Stop</span>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="files/time-left.svg" class="status">
                            <span class="label warning stat-data">Processing</span>
                        </td>
                        <td>
                            <span>Ubuntu Linux N4</span>
                        </td>
                        <td>
                            <span>129293845c422</span>
                        </td>
                        <td>
                                <span class="button action-btn deleteServer">
                                    <span>Verwijderen</span>
                                </span>
                        </td>
                        <td>
                                <span class="button action-btn resetServer">
                                    <span>Reset</span>
                                </span>
                        </td>
                        <td>
                                <span class="button action-btn stopServer" disabled>
                                    <span>Stop</span>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="files/time-left.svg" class="status">
                            <span class="label warning stat-data">Processing</span>
                        </td>
                        <td>
                            <span>MariaDB N4</span>
                        </td>
                        <td>
                            <span>129293845c422</span>
                        </td>
                        <td>
                                <span class="button action-btn deleteServer">
                                    <span>Verwijderen</span>
                                </span>
                        </td>
                        <td>
                                <span class="button action-btn resetServer">
                                    <span>Reset</span>
                                </span>
                        </td>
                        <td>
                                <span class="button action-btn stopServer" disabled>
                                    <span>Stop</span>
                                </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>


        <div class="cell small-24 callout contact">
            <p>
                Neem bij vragen of problemen contact op met dhr. Van Gemert.
                <a href="mailto:pgemert@deltion.nl">pgemert@deltion.nl</a>
            </p>
        </div>
    </div>

</div>

<?php include "includes/clouds.php"; ?>

<script src="foundation/js/vendor/what-input.js"></script>
<script src="foundation/js/vendor/foundation.min.js"></script>
<script src="foundation/js/app.js"></script>
<script src="js/loadingbar.js"></script>
<script src="js/app.js"></script>
</body>
</html>