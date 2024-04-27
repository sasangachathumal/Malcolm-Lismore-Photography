$(document).ready(function () {
    $(document).on("click", "#logoutBtn", function () {
        const message = 'Are you sure you want to Logout !';
        if (confirm(message) == true) {
            window.location.href = 'index.php';
        }
    });
    setActiveClass('home');

    $(document).on("click", "#moreBtn", function () {
        $('html, body').animate({
            scrollTop: $("#about").offset().top
        }, 2000);
        setActiveClass('about');
    });
    $(document).on("click", "#aboutClientBtn", function () {
        $('html, body').animate({
            scrollTop: $("#about").offset().top
        }, 2000);
        setActiveClass('about');
    });
    $(document).on("click", "#galleryClientBtn", function () {
        $('html, body').animate({
            scrollTop: $("#gallery").offset().top
        }, 2000);
        setActiveClass('gallery');
    });
    $(document).on("click", "#serviceClientBtn", function () {
        $('html, body').animate({
            scrollTop: $("#service").offset().top
        }, 2000);
        setActiveClass('service');
    });

    function setActiveClass(page = 'home') {
        var home = $('#homeClientBtn').parent();
        var service = $('#serviceClientBtn').parent();
        var gallery = $('#galleryClientBtn').parent();
        var about = $('#aboutClientBtn').parent();
        switch (page) {
            case 'home':
                home.removeClass('active');
                service.removeClass('active');
                gallery.removeClass('active');
                about.removeClass('active');
                home.addClass('active');
                break;
            case 'about':
                home.removeClass('active');
                service.removeClass('active');
                gallery.removeClass('active');
                about.removeClass('active');
                about.addClass('active');
                break;
            case 'gallery':
                home.removeClass('active');
                service.removeClass('active');
                gallery.removeClass('active');
                about.removeClass('active');
                gallery.addClass('active');
                break;
            case 'service':
                home.removeClass('active');
                service.removeClass('active');
                gallery.removeClass('active');
                about.removeClass('active');
                service.addClass('active');
                break;
            default:
                home.removeClass('active');
                service.removeClass('active');
                gallery.removeClass('active');
                about.removeClass('active');
                home.addClass('active');
                break;
        }
    }
});