<div class="row">
	<div class="col-md-8">
		
		<div class="card">
			<div class="card-header border-bottom">
				<div class="d-flex justify-content-between">
					<div>
						<h4>Select Your Payment Method</h4>
						Secure and Encrypted Payment
					</div>
					<div class="text-end pt-3">
						<img src="/assets/img/payment/ic-mcafee.png">
					</div>
				</div>

				
			</div>
			<div class="card-body">
			
			
				<h6>Your Order Summary</h6>
				<?php foreach ($item as $key => $value) { ?>
					<div class="d-flex justify-content-between">
						<div><?php echo $value->name;?></div>
						<div>$<?php echo $value->price;?></div>
					</div>
				<?php } ?>
				
				
				
				<hr>
				
				<div class="d-flex justify-content-between">
					<div>Total</div>
					<div class="text-success"><?php echo $cost;?> $</div>
				</div>
				<?php if($discordline && $discordline > 0){ ?>
				<div class="d-flex justify-content-between">
					<div><b>Discount <?php echo $discordLine;?>%</b></div>
					<div class="text-success">-<?php echo $discord;?> $</div>
				</div>
				<?php } ?>

				
				<div class="d-flex justify-content-between">
					<h4>Payment</h4>
					<h4 class="text-success"><?php echo $payment;?> $</h4>
				</div>

				<?php if(!logged_in()){?>
					<div class="row mb-3 mt-4">
						<div class="col-lg-6"><input type="email" name="" placeholder="Email" class="form-control"></div>
						<div class="col-lg-6"><input type="password" name="" placeholder="Password" class="form-control"></div>
					</div>
				<?php } ?>


				<form method="post">
				<div class="">

					<ul class="nav nav-pills" id="paymentTabs" role="tablist">
					  <li class="nav-item" role="presentation" id="paypal-tab" data-bs-toggle="tab" data-bs-target="#paypal" type="button" role="tab" aria-controls="paypal" aria-selected="true">
					    <label><div class="paypal"><input type="radio" name="methodpayment" value="paypal"></div></label>
					  </li>

					  <li class="nav-item" role="presentation" id="credit-tab" data-bs-toggle="tab" data-bs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false">
					    <label><div class="credit"><input type="radio" name="methodpayment" value="credit"></div></label>
					  </li>
					  <li class="nav-item" role="presentation" id="crypto-tab" data-bs-toggle="tab" data-bs-target="#crypto" type="button" role="tab" aria-controls="crypto" aria-selected="false">
					    <label><div class="crypto"><input type="radio" name="methodpayment" value="crypto"></div></label>
					  </li>
					  
					</ul>
				</div>
				
				<div class="tab-content">
				  <div class="tab-pane active" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
				  		<button class="btn btn-lg btn-primary" type="submit">Pay with Paypal</button>

				  </div>
				  <div class="tab-pane" id="credit" role="tabpanel" aria-labelledby="credit-tab">
				  	<button class="btn btn-lg btn-primary">Pay with Credit</button>
				  </div>
				  <div class="tab-pane" id="crypto" role="tabpanel" aria-labelledby="crypto-tab">
				  	<button class="btn btn-lg btn-primary">Pay with Cripto</button>
				  </div>
				  
				</div>
				</form>
				By submitting this form you agree to our Terms of service and Privacy Policy.

			</div>
			<div class="card-footer"></div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<ul>
					<li>Apps for Enterprise-grade security </li>
					<li>10-Multi logins so you can use one account on 10 devices at the same time. </li>
					<li>6500+ secure servers in 78+ countries </li>
					<li>24/7 customer support</li>
				</ul>
				<img src="/assets/img/payment/cart_reassurance_purple_new.png" style="width:100%;">
			</div>
		</div>
		
	</div>
</div>