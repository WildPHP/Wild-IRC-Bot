<?php

/*
	WildPHP - a modular and easily extendable IRC bot written in PHP
	Copyright (C) 2016 WildPHP

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace WildPHP\Core\Connection\Commands;


class Part extends BaseCommand
{
	/**
	 * @var string|array
	 */
	protected $channel;

	/**
	 * @param string|array $channel
	 * @param string|array $key
	 */
	public function __construct($channel, $key = '')
	{
		$this->setChannel($channel);
	}

	/**
	 * @return string|array
	 */
	public function getChannel()
	{
		return $this->channel;
	}

	/**
	 * @param string|array $channel
	 */
	public function setChannel($channel)
	{
		$this->channel = $channel;
	}

	public function formatMessage(): string
	{
		$channels = $this->getChannel();
		$chans = '';
		if (is_array($channels))
			$chans = implode(',', $channels);

		return 'PART ' . $chans . "\r\n";
	}
}