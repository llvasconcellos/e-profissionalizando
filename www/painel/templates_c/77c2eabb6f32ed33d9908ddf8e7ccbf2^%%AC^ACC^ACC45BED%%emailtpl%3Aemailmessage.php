<?php /* Smarty version 2.6.26, created on 2011-01-20 21:44:25
         compiled from emailtpl:emailmessage */ ?>
<p>
Dear <?php echo $this->_tpl_vars['client_name']; ?>
, 
</p>
<p>
We have received your order and will be processing it shortly. The details of the order are below: 
</p>
<p>
Order Number: <b><?php echo $this->_tpl_vars['order_number']; ?>
</b></p>
<p>
<?php echo $this->_tpl_vars['order_details']; ?>
 
</p>
<p>
You will receive an email from us shortly once your account has been setup. Please quote your order reference number if you wish to contact us about this order. 
</p>
<p>
<?php echo $this->_tpl_vars['signature']; ?>

</p>