<div class="modal-container">
    <div class="grid-x grid-padding-x grid-padding-y">

        <div class="cell small-24 medium-10">

            <h4>Reserveer Server</h4>

            <p>
                Hier maak je een nieuwe server aan. Kies het type dat je wilt en kies een gebruikersnaam en wachtwoord.
            </p>

            <span id="close-button" data-close>
                <svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1" class="angle-left">
                    <path style="fill:none;stroke-width: 1px;stroke: #000;"
                          d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
                </svg>
                <span>Ga terug</span>
            </span>

        </div>

        <div class="cell small-24 medium-14">

            <form class="form-leader">
                <div class="grid-y grid-padding-y">

                    <div class="cell small-24">
                        <table class="unstriped server-choices">
                            <tr>
                                <td colspan="2">
                                    <div class="callout border">
                                        <b>Stap 1</b>
                                        <p>Kies het type server dat je wilt aanmaken</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="radio-container">
                                        <input type="radio" id="linux" name="radio-group">
                                        <label for="linux">Linux - N3</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="radio-container">
                                        <input type="radio" id="centos" name="radio-group">
                                        <label for="centos">CentOS Linux - N4</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="radio-container">
                                        <input type="radio" id="ubuntu" name="radio-group">
                                        <label for="ubuntu">Ubuntu Linux - N4</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="radio-container">
                                        <input type="radio" id="mariadb" name="radio-group">
                                        <label for="mariadb">MariaDB - N4</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="output-container">
                                        <span class="output-1"></span>
                                        <span class="output-2"></span>
                                        <span class="output-3"></span>
                                        <span class="output-4"></span>
                                    </div>
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div class="cell small-24">
                        <div class="form-division">
                            <div class="callout border">
                                <b>Stap 2</b>
                                <p>Kies een gebruikersnaam en wachtwoord voor deze server</p>
                            </div>
                            <div class="form-group">
                                <label for="useraccount">Gebruikersnaam</label>
                                <input type="text" id="useraccount" placeholder="Gebruikersnaam">

                                <!-- Requirements -->
                                <div class="requirements useraccount">
                                    <ul>
                                        <li>Alleen letters</li>
                                        <li>Geen cijfers</li>
                                        <li>Geen leestekens</li>
                                        <li>Maximaal 8 tekens</li>
                                        <li>Mag niet student zijn</li>
                                        <li>Mag niet root zijn</li>
                                        <li>Mag niet dba zijn</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="userpassword">Wachtwoord</label>
                                <input type="text" id="userpassword" placeholder="Wachtwoord">

                                <!-- Requirements -->
                                <div class="requirements userpassword">
                                    <ul>
                                        <li>Onthoud dit wachtwoord</li>
                                        <li>Gebruik een uniek wachtwoord</li>
                                        <li>Wachtwoord wordt ook in tekst opgeslagen op server</li>
                                        <li>Gebruik geen wachtwoord die je voor andere services gebruikt</li>
                                        <li>Deze kun je vinden in de bevestigingsemail</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <button class="reserveerServer">
                                <span>Reserveer server</span>
                                <?php include '../../../files/angle-right.html'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="js/create.js"></script>
<script>
    $(document).ready(function () {
        let spinnerButton;
        return spinnerButton = new SpinnerButton($(".reserveerServer"),
            () => setTimeout(() => spinnerButton.stop(), 1000));
    });
</script>