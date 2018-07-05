window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}, false);


$(document).ready(function() {
    const forms = $('.needs-validation');
    const validation = Array.prototype.filter.call(forms, function(form) {
        const errors = jQuery(form).find( '.invalid-feedback' );
        let isInvalid = false;
        errors.each( function() {
            const el = $(this);

            if( el.html().trim().length > 0 ) {
                isInvalid = true;
            }

            form.classList.add('was-validated');
        });

        /*
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        */
    });
});
