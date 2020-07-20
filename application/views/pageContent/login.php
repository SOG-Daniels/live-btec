<style> 
body {
  background: url(<?php echo base_url()?>assets/img/BTEC_Building.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>


<div class="container-fluid" >
	<div class="row mt-5">
		<div class="col-md-12 d-flex justify-content-center mt-5"> 
			<div class="card shadow-lg" style="width: 25rem;" >
			<div class="card-body">
			<div class="text-center">
				<img src="<?php echo base_url();?>assets/img/BTEC _login_logo.png" alt="BTEC Logo" width="200px" height="100px">
			</div>
				<!-- <h4 class="card-title text-center mb-4 mt-1">Login</h4> -->
				<hr>
				<?php echo (!empty($this->session->flashdata('message')))? $this->session->flashdata('message') : ''; 
				?>
				<form role="form" method="POST" action="<?php echo base_url()?>login">
				<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> <i class="fa fa-user"></i> </span>
					</div>
					<input name="email" class="form-control" placeholder="Enter your Email..." type="email" required>
				</div> <!-- input-group.// -->
				</div> <!-- form-group// -->
				<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
					</div>
					<input class="form-control" name="pass" placeholder="******" type="password" required>
				</div> <!-- input-group.// -->
				</div> <!-- form-group// -->
				<div class="form-group">
				<input type="hidden" name="action" value="login">
				<button type="submit" class="btn btn-primary btn-block"> Login  </button>
				</div> <!-- form-group// -->
				
				</form>
				<div class="text-center">
					<a class="small" href="<?php echo site_url('forgot-password'); ?>">Forgot Password?</a>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>




