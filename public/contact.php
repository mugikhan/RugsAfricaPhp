<?php require_once("../resources/config.php"); session_start();?>

<?php include(TEMPLATE_FRONT . DS . "header.php");?>


<main class="content-wrapper">
    <div class="container-fluid">
        <section id="ContactUs">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <img src="assets/images/contact-page-image.jpg" class="contact-img">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12 col-12">
                    <h1 class="h1-responsive contact-heading">Contact Us</h1>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-8 col-12">
                    <form method="POST" action="inputForm.php" class="contact-form">
                        <div class="md-form form-sm"> <i class="fas fa-user prefix"></i></i>
                            <input required type="text" name="userName" id="userNameField" class="form-control form-control-sm">
                            <label for="userNameField">Your name*</label>
                        </div>

                        <div class="md-form form-sm"> <i class="fas fa-envelope prefix"></i>
                            <input required type="email" name="userEmail" id="userEmailField" class="form-control form-control-sm">
                            <label for="userEmailField">Your email*</label>
                        </div>

                        <div class="md-form form-sm"> <i class="fas fa-tag prefix"></i>
                            <input required type="text" name="userSubject" id="userSubjectField" maxlength="30" class="form-control form-control-sm">
                            <label for="userSubjectField">Subject*</label>
                        </div>

                        <div class="md-form form-sm"> <i class="fas fa-edit prefix"></i>
                            <textarea required type="text" name="userMessage" id="userMessageField" class="md-textarea form-control form-control-sm" rows="4"></textarea>
                            <label for="userMessageField">Your message*</label>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12 col-12 text-center">
                                <div class="g-recaptcha" data-sitekey="6LfDv3EUAAAAAKjspK9gjJya08VgAlkT7uEFPYnr"></div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-outline-elegant" type="submit">Send<i class="fa fa-paper-plane ml-1"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3583.325687324721!2d28.090761314746253!3d-26.08828516560589!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e9572b9a138b4d1%3A0x3846c1247ecf1422!2s1st+Floor%2C+27+15th+St%2C+Marlboro%2C+Sandton%2C+2063!5e0!3m2!1sen!2sza!4v1522141874230"
                            width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen>
                    </iframe>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include(TEMPLATE_FRONT . DS . "footer.php");?>

<!-- /.container -->