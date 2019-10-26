<div class="modal-container">
    <div class="grid-x grid-padding-x grid-padding-y">

        <div class="cell small-24 medium-12">

            <h4>Reset Server</h4>

            <p class="callout border">
                Met dit formuleer annuleer jij de server die jij momenteel in gebruik hebt.
            </p>

            <p>
                Dit betekent dat de server uitgezet wordt en daarna verwijderd. Na de annulering ben je alle data kwijt
                die jij
                mogelijkerwijs op de server had opgeslagen.
                Het is niet mogelijk om de annulering weer ongedaan te maken!
            </p>

            <span id="close-button" data-close>
                <svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1" class="angle-left">
                    <path style="fill:none;stroke-width: 1px;stroke: #000;"
                          d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
                </svg>
                <span>Ga terug</span>
            </span>

        </div>

        <div class="cell small-24 medium-12">

            <div class="validation-modal">
                <div class="grid-x">

                    <div class="cell small-24">
                        <div class="validation-inner">
                            <img src="files/warning-sign.svg" class="warning-sign">
                        </div>
                    </div>

                    <div class="cell small-24 message">
                        <p>Weet je zeker dat je deze server wilt resetten?</p>
                    </div>


                    <div class="cell small-24">
                        <div class="button-group">
                            <button class="delete-btn resetServerModal">
                                <span>Reset server</span>
                                <?php include '../../../files/angle-right.html'; ?>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<script>
    // Spinner button
    $(document).ready(function () {
        let spinnerButton;
        return spinnerButton = new SpinnerButton($(".resetServerModal"),
            () => setTimeout(() => spinnerButton.stop(), 1000));
    });
</script>