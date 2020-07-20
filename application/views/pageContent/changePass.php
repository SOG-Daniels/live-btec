<!-- Begin Page Content -->
<style> 
body {
  background: url(<?php echo base_url()?>assets/img/BTEC_Building.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>

<div class="container-fluid">   
    <div class="row mt-5">
        <div class="col-md-12 d-flex justify-content-center mt-5"> 
            <div class="card" style="width: 25rem;" >
            <div class="card-body">
                <h4 class="card-title text-center mb-4 mt-1">Enter your email</h4>
                <hr>
				<?php echo (isset($message))? $message: ''; ?>
                <form role="form" method="POST" action="<?php echo base_url().'reset-password';?>">
                <input type="hidden" name="action" value="changePass">
                <input type="hidden" name="resetId" value="<?php echo (isset($resetId)? $resetId : '')?>">
                <input type="hidden" name="token" value="<?php echo (isset($token)? $token : '')?>">
                <div class="alert alert-secondary" role="alert">
                    <i class="fa fa-exclamation"></i>
                    New password length must be 8 characters including a upper, lower case letter and a number.
                    
                </div>
                <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="newPass" id="newPassword" class="form-control" placeholder="password" type="password" required>
                </div> <!-- input-group.// -->
                </div> <!-- form-group// -->
                <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="confirmPass" id="confirmPassword" class="form-control" placeholder="password" type="password" required>
                </div> <!-- input-group.// -->
                </div> <!-- form-group// -->
                <div class="form-group">
                <div class="registrationFormAlert row col col-md-12 ml-md-5 pb-2" id="divCheckPasswordMatch">

                </div>
                <button id="change-pass-btn" type="submit" class="btn btn-primary btn-block">Change Password</button>
                </div> <!-- form-group// -->
                </form>
				<div class="text-center">
					<a class="small" href="<?php echo site_url('login'); ?>">I have an Account</a>
				</div>
            </div>
            </div>
        </div>
    </div>

