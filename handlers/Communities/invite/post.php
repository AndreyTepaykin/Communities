<?php

/**
 * Invites a user (or a future user) to a stream .
 * @param {array} $_REQUEST
 * @param {string} $_REQUEST.publisherId The id of the stream publisher
 * @param {string} $_REQUEST.streamName The name of the stream the user will be invited to
 *  @param {string|array} [$_REQUEST.userId] user id or an array of user ids
 *  @param {string} [$_REQUEST.platform] platform for which xids are passed
 *  @param {string|array} [$_REQUEST.xid] platform xid or array of platform xids
 *  @param {string} {$_REQUEST.label} label or an array of labels, or tab-delimited string
 *  @param {string} [$_REQUEST.identifier] identifier or an array of identifiers
 *  @param {string|array} [$_REQUEST.addLabel] label or an array of labels for adding publisher's contacts
 *  @param {string|array} [$_REQUEST.addMyLabel] label or an array of labels for adding logged-in user's contacts
 *  @param {string} [$_REQUEST.readLevel] the read level to grant those who are invited
 *  @param {string} [$_REQUEST.writeLevel] the write level to grant those who are invited
 *  @param {string} [$_REQUEST.adminLevel] the admin level to grant those who are invited
 *	@param {string} [$_REQUEST.displayName] the name of inviting user
 * @see Users::addLink()
 */
function Communities_invite_post()
{
	$app = Q::app();
	$communityId = Q::ifset($_REQUEST, 'communityId', Users::communityId());
	$community = Users_User::fetch($communityId);
	if (!$community) {
		throw new Q_Exception("No community found with id $communityId");
	}
	$allowed = Q_Config::expect('Communities', 'community', 'canInvite');
	if (!Users::roles($communityId, $allowed)) {
		throw new Users_Exception_NotAuthorized();
	}
	$publisherId = Streams::requestedPublisherId(true);
	$streamName = Streams::requestedName(true);
	$options = array_merge($_REQUEST, array(
		'asUserId' => $communityId
	));
	Streams::$cache['invited'] = Streams::invite(
		$publisherId, 
		$streamName, 
		$_REQUEST, 
		$options
	);
}