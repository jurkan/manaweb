<h3>Welcome <?= $user->username ?>!</h3>

<p>From this page you can manage several options of your account. Also you can
   get current statistics of you characters. Please choose one option 
   below:

   <ul>
        <li>View your character stats</li>
        <li>Change your password</li>
        <li>Change your mailaddress</li>
   </ul>   
</p>
   


<p>Your current state is <strong><?= $levelstring ?></strong>.</p>

<?php if ($this->user->hasCharacters()){ ?>
<h3>Character overview</h3>

<p>Here you see a summary of all your characters. Click on the name
of one to see its details.</p>

<table style="border-width: 0px; margin-bottom: 0px;">
<tr>
	<th>Name</th>
	<th>Level</th>
	<th>Gender</th>
	<th>Money</th>
</tr>
<?php foreach ($this->user->getCharacters() as $char){ ?>
<tr>
	<td><a href="<?= site_url('accountmanager/character/' . 
		$char->getID()) ?>"><?= $char->getName() ?></a></td>
	<td align="right"><?= $char->getLevel() ?></td>
	<td><? 
		switch ($char->getGender())
		{
			case Character::GENDER_MALE:
				echo "<img src=\"" . base_url() . "images/gender_male.gif\">";
				break;
			case Character::GENDER_FEMALE:
				echo "<img src=\"" . base_url() . "images/gender_female.gif\">";
				break;
		} 
	?></td>
	<td align="right"><?= number_format($char->getMoney(), 0, ".", ",") ?></td>
</tr>
<? } ?>
</table>	

<?php } ?>

