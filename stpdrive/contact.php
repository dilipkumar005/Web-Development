<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - STPDrive</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
    <?php include('element/nav.php'); ?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5">
            <h1 class="display-4 fw-bold text-light">Get In Touch</h1>
            <p class="lead text-muted">
                We'd love to hear from you
            </p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-4">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                    <h3 class="h4">Contact Form</h3>
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                    <div id="formResponse" class="mt-3"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-4">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                    </div>
                    <h3 class="h4">Our Office</h3>
                    <p class="text-muted">
                        <i class="fas fa-building me-2"></i> 123 Drive Street, Cloud City<br>
                        <i class="fas fa-phone me-2"></i> +1 (555) 123-4567<br>
                        <i class="fas fa-envelope me-2"></i> support@stpdrive.com
                    </p>
                    <div class="mt-4">
                        <h4 class="h5">Business Hours</h4>
                        <p class="text-muted">
                            Monday - Friday: 9am - 5pm<br>
                            Saturday - Sunday: Closed
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('element/footer.php'); ?>

<script>
$(document).ready(function() {
    $('#contactForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "php/contact_submit.php",
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                message: $('#message').val()
            },
            beforeSend: function() {
                $('#formResponse').html('<div class="alert alert-info">Sending message...</div>');
            },
            success: function(response) {
                $('#formResponse').html('<div class="alert alert-success">Message sent successfully!</div>');
                $('#contactForm')[0].reset();
            },
            error: function() {
                $('#formResponse').html('<div class="alert alert-danger">Failed to send message. Please try again.</div>');
            }
        });
    });
});
</script>

</body>
</html>
