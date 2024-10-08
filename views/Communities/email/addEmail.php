<div style="text-align: center">
        <?php echo Q_Html::img('img/icon/200.png') ?>
</div>

<p>
	<?php echo Q::text($Greetings, array($communityName)) ?>
</p>

<p>
	<?php echo Q::interpolate($activation['ReallyYourEmail'], 
		array($user->displayName(), $link)
	) ?>
</p>

<p>
	(<?php echo Q::interpolate($resend['DomainCode'], compact('domain', 'code')) ?>)
</p>

<p>
	<?php echo Q::interpolate($activation['SeeYou'],
		array(Q_Request::baseUrl(), $communityName)
	) ?>
</p>

<p style="margin-top: 100px;">
	<?php echo Q::interpolate($LinkToUnsubscribe, array($unsubscribe)) ?>
</p>
