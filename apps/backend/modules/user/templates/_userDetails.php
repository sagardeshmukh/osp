<div>
	<h2 style="float:left;">User Details</h2>
	<table style="clear: both; width: 50%; border:medium;">
	  <tr><td colspan="4"></td></tr>
	  <tr><td></td></tr>
	  <tr>
		<td><?php echo __('User Name:') ?></td><td><?php echo $user->getUsername(); ?></td>
		<td><?php echo __('Email:') ?></td> <td><?php echo $user->getEmail(); ?></td>
	  </tr>
	  <tr>
		<td><?php echo __('Name:') ?></td>
		<td><?php echo $user->getFirstname()." ".$user->getLastname(); ?></td>
	  </tr>
	</table>
</div>


