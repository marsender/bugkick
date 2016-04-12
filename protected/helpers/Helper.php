<?php

/**
 * User: Alex kavshirko@gmail.com
 * Date: 16.10.11
 * Time: 16:47
 */
class Helper
{

	// Ordinary trimming
	public static function truncateString($string, $limit = 25, $break = ' ', $pad = "&#133;")
	{
		// return with no change if string is shorter than $limit
		if (mb_strlen($string) <= $limit) {
			return $string;
		}

		$string = mb_substr($string, 0, $limit);
		if (false !== ($breakpoint = mb_strrpos($string, $break))) {
			$string = mb_substr($string, 0, $breakpoint);
		}

		return $string . $pad;
	}

	// Use for trimming and keep words unbroken
	public static function neatTrim($str, $n, $delim = '&#133;')
	{
		$len = mb_strlen($str);
		if ($len > $n) {
			$str = rtrim(preg_replace('/\s+?(\S+)?$/', '', mb_substr($str, 0, $n)));
			$str = preg_replace('#</?[^>]*$#', '', $str);
			$str .= $delim;
			if (preg_match('#<(\w+)[^>/]*>(?!</\w+>.*?$)#', $str, $matches))
				$str .= '</' . $matches[1] . '>';
			return $str;
		}
		else {
			return $str;
		}
	}

	// Format date and time to 12h format
	public static function formatDate12($date = null)
	{
		$format = Yii::app()->params['date']['formatDate12'];
		if ($date)
			return date($format, strtotime($date));
		else
			return date($format);
	}

	// Format date to format:  oct 12
	public static function formatDateShort($date)
	{
		$format = Yii::app()->params['date']['formatDateShort'];
		return strtolower(date($format, strtotime($date)));
	}

	// Format date to format:  03th December 2011
	public static function formatDateLong($date = null)
	{
		$format = Yii::app()->params['date']['formatDateLong'];
		if ($date)
			return strtolower(date($format, strtotime($date)));
		else
			return strtolower(date($format));
	}

	// Format date to format:  2/25/12 - mon/day/year
	public static function formatDateSlash($date = null)
	{
		$format = Yii::app()->params['date']['formatDateSlash'];
		if ($date)
			return strtolower(date($format, strtotime($date)));
		else
			return strtolower(date($format));
	}

	// Format date to format:  2/25/12 at 10:38pm - mon/day/year at time
	public static function formatDateSlashFull($date = null)
	{
		$format = Yii::app()->params['date']['formatDateSlashFull'];
		if ($date)
			return strtolower(date($format, strtotime($date)));
		else
			return strtolower(date($format));
	}

	// Format date to format:  2nd April 2012 - 3:42pm
	public static function formatDateLongWithTime($date = null)
	{
		$format = Yii::app()->params['date']['formatDateLongWithTime'];
		if ($date)
			return date($format, strtotime($date));
		else
			return date($format);
	}

	/**
	 * Formats size to readable view
	 *
	 * @param integer $size in bytes
	 * @param null $retString
	 * @return string
	 */
	public static function getReadableFileSize($size, $retString = null)
	{
		// adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
		$sizes = array(
			'bytes',
			'kB',
			'MB',
			'GB',
			'TB',
			'PB',
			'EB',
			'ZB',
			'YB'
		);

		if ($retString === null) {
			$retString = '%01.2f %s';
		}

		$lastSizeString = end($sizes);

		foreach ($sizes as $sizeString) {
			if ($size < 1024) {
				break;
			}
			if ($sizeString != $lastSizeString) {
				$size /= 1024;
			}
		}
		if ($sizeString == $sizes[0]) {
			$retString = '%01d %s';
		} // Bytes aren't normally fractional
		return sprintf($retString, $size, $sizeString);
	}
}
