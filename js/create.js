$(document).ready(function radioListener() {

    let linux = $('#linux');
    let centos = $('#centos');
    let ubuntu = $('#ubuntu');
    let mariadb = $('#mariadb');

    $('input').on('click', function () {
        if (linux.is(':checked')) {
            // console.log('You have Checked Linux');
            $(".output-1").html("<img src='files/servers/linux-logo.png' class='server-logo linux'><span>Linux Server N3</span>");

        } else {
            $(".output-1").html("&nbsp");
        }
    });

    $('input').on('click', function () {
        if (centos.is(':checked')) {
            // console.log('You have Checked Centos');
            $(".output-2").html("<img src='files/servers/centos-logo.png' class='server-logo centos'><span>Centos Server N3</span>");

        } else {
            $(".output-2").html("&nbsp");
        }
    });

    $('input').on('click', function () {
        if (ubuntu.is(':checked')) {
            // console.log('You have Checked ubuntu');
            $(".output-3").html("<img src='files/servers/ubuntu-logo.png' class='server-logo ubuntu'><span>Ubuntu Server N4</span>");
        } else {
            $(".output-3").html("&nbsp");
        }
    });

    $('input').on('click', function () {
        if (mariadb.is(':checked')) {
            // console.log('You have Checked Mariadb');
            $(".output-4").html("<img src='files/servers/mariadb-logo.png' class='server-logo mariadb'><span>MariaDB Server N4</span>");
        } else {
            $(".output-4").html("&nbsp");
        }
    });
});