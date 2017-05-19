<?php
/**
 * Created by PhpStorm.
 * User: rkerkhof
 * Date: 6-5-17
 * Time: 16:46
 */

namespace WildPHP\Core\Connection\IRCMessages;
use WildPHP\Core\Connection\IncomingIrcMessage;

/**
 * Class RPL_ENDOFNAMES
 * @package WildPHP\Core\Connection\IRCMessages
 *
 * Syntax: :server 366 nickname #channel :End of /NAMES list.
 */
class RPL_ENDOFNAMES implements BaseMessage
{
	use NicknameTrait;
	use ChannelTrait;
	use MessageTrait;

	protected static $verb = '366';

	/**
	 * @param IncomingIrcMessage $incomingIrcMessage
	 *
	 * @return \self
	 * @throws \InvalidArgumentException
	 */
	public static function fromIncomingIrcMessage(IncomingIrcMessage $incomingIrcMessage): self
	{
		if ($incomingIrcMessage->getVerb() != self::$verb)
			throw new \InvalidArgumentException('Expected incoming ' . self::$verb . '; got ' . $incomingIrcMessage->getVerb());

		$args = $incomingIrcMessage->getArgs();
		$nickname = array_shift($args);
		$channel = array_shift($args);
		$message = array_shift($args);

		$object = new self();
		$object->setNickname($nickname);
		$object->setChannel($channel);
		$object->setMessage($message);

		return $object;
	}
}