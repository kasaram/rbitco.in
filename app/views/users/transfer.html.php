<div class="alert alert-warning">
<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Transfer on another account</h4>
	<p>You can transfer the amount to a bitcoin address.</p>
</div>
<?php
if(isset($success)){
?>
<div class="alert alert-warning">
<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Not Transfered</h4>
	<p>Amount <?=$amount?> not transfered to <?=$address?>. </p>
</div>
<?php 
	print_r($error);
}
if(isset($success)){
?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Transfered</h4>
	<p>Amount <?=$amount?> transfered to <?=$address?>. It may take about 10 to 20 minutes to reflect in the new account. </p>
	<?php print_r($success); ?>
</div>
<?php }?>
<h4>Transfer</h4>
<p>You can transfer a minimum of 0.5 BTC to any address your wallet balance is <strong><?=number_format($walletbal,8)?></strong>. Please add funds to your wallet before you make a transfer.</p>
<p><a href="/users/addfunds" class="btn btn-primary">Add funds to your wallet</a></p>
<p>Transaction fees may be included with any transfer of Bitcoins. Many transactions are processed in a way which makes no charge for the transaction. For transactions which consume or produce many coins (and therefore have a large data size), a small transaction fee is usually expected. </p>
<?=$this->form->create("",array('url'=>'/users/transfer/')); ?>
<?=$this->form->field('amount', array('label'=>'Amount','placeholder'=>'0.1' )); ?>
<?=$this->form->field('address', array('label'=>'Bitcoin Address','placeholder'=>'Bitcoin address')); ?>
<?=$this->form->field('verifyAddress', array('label'=>'Verify Bitcoin Address','placeholder'=>'Bitcoin address')); ?>
<?=$this->form->field('comment', array('label'=>'Comment','placeholder'=>'comment')); ?>
<?=$this->form->hidden('maxAmount', array('value'=>number_format($walletbal,8))); ?>
<?=$this->form->submit('Transfer',array('class'=>'btn btn-primary','OnClick'=>'return CompareAmount();')); ?>
<?=$this->form->end(); ?>

