$(document).foundation()

// Foundation Ajax Modal Create
$(document).on('open.zf.reveal', "#modalCreate", function (e) {
    let $modal = $(this);
    let ajax_url = $modal.data("ajax-url");
    if (ajax_url) {
        // $modal.html("<img src=\"../files/ripple.svg)\">");
        $.ajax(ajax_url).done(function (response) {
            $modal.html(response);
        });
    }
});

// Foundation Ajax Modal Delete
$(document).on('open.zf.reveal', "#modalDelete", function (e) {
    let $modal = $(this);
    let ajax_url = $modal.data("ajax-url");
    if (ajax_url) {
        // $modal.html("<img src=\"../files/ripple.svg)\">");
        $.ajax(ajax_url).done(function (response) {
            $modal.html(response);
        });
    }
});

// Foundation Ajax Modal Reset
$(document).on('open.zf.reveal', "#modalReset", function (e) {
    let $modal = $(this);
    let ajax_url = $modal.data("ajax-url");
    if (ajax_url) {
        // $modal.html("<img src=\"../files/ripple.svg)\">");
        $.ajax(ajax_url).done(function (response) {
            $modal.html(response);
        });
    }
});

// Class Spinner Button
window.SpinnerButton = class SpinnerButton {

    constructor($button, clickCallback, options) {

        // set default options
        this.$button = $button;
        this.clickCallback = clickCallback;
        const defaults = {
            buttonContentTag: "span",
            fadeDuration: 0,
            classDuringLoading: "spinning"
        };

        // override the defaults with the passed in options
        this.options = $.extend(defaults, options);

        // if the button has a single dom node inside it, store a reference to it. else, create a new node and put the button text (or children) inside it
        if (this.$button.children().length === 1) {
            this.$childContent = $(this.$button.children()[0]);
        } else {

            this.$childContent = $(`<${this.options.buttonContentTag}>`);

            if (this.$button.children().length > 1) {
                this.$childContent.append(this.$button.children());
            } else {
                this.$childContent.text(this.$button.text());
                this.$button.text("");
            }

            this.$button.append(this.$childContent);
        }

        // listen for click on the button (if we have a callback function)
        if (this.clickCallback != null) {
            this.$button.click((() => this.handleClick()));
        }
    }

    handleClick() {

        // start the loading animation
        this.start();

        // call the click callback function if we have one (else, return true so the natural button event chain continues to fire)
        if (this.clickCallback != null) {
            return this.clickCallback();
        } else {
            return true;
        }
    }

    start() {

        // start the loading animation, set the button's class and fade out the existing button content
        this.$button.addClass(this.options.classDuringLoading);
        this.$childContent.animate({opacity: 0}, this.options.fadeDuration);
        this.spinner = new LoadingSpinner(this.$button, {fadeDuration: this.options.fadeDuration});

        // disable the button
        return this.$button.prop("disabled", "true");
    }

    stop() {

        // fade back in the existing button content and destroy the loading spinner
        this.$childContent.animate({opacity: 1}, this.options.fadeDuration);
        this.spinner.destroy();
        this.spinner = null;

        // re-enable the button and remove its class
        this.$button.prop("disabled", "");
        return this.$button.removeClass(this.options.classDuringLoading);
    }
};

// Spinner Button
window.LoadingSpinner = class LoadingSpinner {

    constructor($container, options) {

        // set default options
        const defaults = {
            fadeDuration: 0
        };

        // override the defaults with the passed in options
        this.options = $.extend(defaults, options);

        // create the spinner and add it to the container
        this.$spinner = $("<div>").addClass("loadingSpinner");
        $container.append(this.$spinner);
        this.$spinner.hide().fadeIn(this.options.fadeDuration);
    }


    destroy() {
        return this.$spinner.fadeOut(this.options.fadeDuration, () => {
            this.$spinner.remove();
            return this.$spinner = null;
        });
    }
};

// Dropdown Menu
$(document).ready(function () {
    $("#droptrigger").click(function () {
        $(".dropcontent, .drop-button, .drop-anchor").toggleClass("open", 1000)
    })
});

