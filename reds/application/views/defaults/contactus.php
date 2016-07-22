<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Contact </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id='main' class="contact">
    <div class="container">
        <div class="row">
            <div class="section-title"><h3 class="text-center">CONTACT US</h3></div>
            <!--send post to contact-->
            <form  action="<?php echo base_url() ?>contactus/sendcontact" method="post" class="contact-form">
                <fieldset>
                    <div class="form-group">                       
                        <input class="form-control" type="text" name="name" id="name" placeholder="Name" required/>
                    </div>
                     <div class="form-group">
                        <input class="form-control" type="email" name="emails" id="emails" placeholder="Email" required/>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" class="message" name="msg" placeholder="Messages" required></textarea>
                    </div>
                     <div class="text-center">
                        <button class="custom-button btn-xl" id="loginButton" type="submit">Send</button>
                    </div>
                </fieldset>
            </form>
        </div>
</section>