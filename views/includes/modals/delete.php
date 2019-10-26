<div class="modal-container">
    <div class="grid-x grid-padding-x grid-padding-y">

        <div class="cell small-24 medium-12">

            <h4>Verwijder Server</h4>

            <p class="callout border">
                Hier annuleer jij de server die jij momenteel in gebruik hebt.
            </p>
            <p>
                Dit betekent dat de server uitgezet wordt en daarna verwijderd. Na de annulering ben je alle data
                kwijt
                die jij mogelijkerwijs op de server had opgeslagen.
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
                        <p>Weet je zeker dat je deze server wilt verwijderen?</p>
                    </div>

                    <div class="cell small-24 form-leader for-delete">
                        <span class="form-title">Server</span>

                        <div class="selected-server container">
                            <label for="checked-selected"><span class="callout">Centos Linux (N4)</span></label>
                            <input type="checkbox" name="radio" id="check-submit">
                            <span class="checkmark offset"></span>
                        </div>
                    </div>


                    <div class="cell small-24">
                        <div class="button-group">
                            <button class="delete-btn verwijderServer" id="delete" disabled>
                                <span>Verwijder server</span>
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
    $(document).ready(function () {
        // Spinner button
        let spinnerButton;
        return spinnerButton = new SpinnerButton($(".verwijderServer"),
            () => setTimeout(() => spinnerButton.stop(), 1000));
    });

    // Checkbox before submit
    $('#check-submit').click(function () {
        if ($(this).is(':checked')) {
            $('#delete').removeAttr('disabled');
        } else {
            $('#delete').attr('disabled', 'disabled');
        }
    });
</script>