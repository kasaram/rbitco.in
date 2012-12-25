<?php
?>
<h4>Settings</h4>
<div class="accordion-group" style="background-color:#FFFFFF ">
	<div class="accordion-heading" style="background-color:#D5E2C5 ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsePersonal">
		<strong class="label label-success">Personal details:</strong>
		</a>
	</div>
	<div id="collapsePersonal" class="accordion-body collapse">
		<div class="accordion-inner">
		<p>Your personal details are used for signing in to rBitcoin and accessing your account. 
		You can have only one account with a unique email address and a mobile number.</p>
		<table class="table">
			<tr>
				<td>Name:</td>
				<td><?=$user['firstname']?> <?=$user['lastname']?></td>
			</tr>
			<tr>
				<td>Username:</td>
				<td><?=$user['username']?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><?=$user['email']?> <?php 
					if($details['email']['verified']=='Yes'){
						echo '<a href="#" class="label label-success">Verified</a>';
						}else{
						echo '<a href="/users/email"  class="label label-important">Verify</a>';
						}?></td>
			</tr>
			<?php
				if($details['email']['verified']=='Yes'){
			?>
			<tr>
				<td>Mobile:</td>
				<td><?php 
					if($details['mobile']['verified']==''){
						echo "<a href='/users/confirm/".$user['email']."/".$user['_id']."'  class='label label-important'>Verify</a>";
						}else{
						echo $details['mobile'];
					}?></td>
			</tr>
			<?php }?>
		</table>
		</div>
	</div>
	<div class="accordion-heading" style="background-color:#c0d1b0">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseBank">
		<strong class="label label-success">Financial details:</strong>
		</a>
	</div>
	<div id="collapseBank" class="accordion-body collapse">
		<div class="accordion-inner">
		<a href="/users/addbank">Add a new bank</a>
		<table class="table">
			<tr>
				<td>Bank Name:</td>
				<td><?=$details['bankname']?></td>
				<td>edit</td>
				<td>delete</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="accordion-heading" style="background-color:#b0c1a0 ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseAPI">
		<strong class="label label-success">API Keys:</strong>
		</a>
	</div>
	<div id="collapseAPI" class="accordion-body collapse">
		<div class="accordion-inner">
		</div>
	</div>

	<div class="accordion-heading" style="background-color:#F7CCBF ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseDelete">
		<strong class="label label-important">Delete Account</strong>
		</a>
	</div>
	<div id="collapseDelete" class="accordion-body collapse">
		<div class="accordion-inner">
		<table class="table">
			<tr>
				<td>Bank Name:</td>
				<td><?=$details['bankname']?></td>
			</tr>
		</table>
		</div>
	</div>

</div>
<?php
//print_r($details);
?>