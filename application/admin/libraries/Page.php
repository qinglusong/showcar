<?php

/**
 * Page.php
 * 
 * Copyright (c) 2012 SINA Inc. All rights reserved.
 * 
 * @author	ligangzong <gangzong@staff.sina.com.cn>
 * @date	10:49:06 2012-12-25
 * @version	$Id: Page.php 47 2012-12-25 07:36:02Z gangzong $
 * @desc	This guy is so lazy that he doesn't leave anything.
 */
class Page
{

	/**
	 * 分页函数
	 *
	 * @param $num 信息总数
	 * @param $curr_page 当前分页
	 * @param $perpage 每页显示数
	 * @param $urlrule URL规则
	 * @param $array 需要传递的数组，用于增加额外的方法
	 * @return 分页
	 */
	public static function pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(), $setpages = 10)
	{
		if (defined('URLRULE') && $urlrule == '') {
			$urlrule = URLRULE;
			$array = $GLOBALS['URL_ARRAY'];
		} elseif ($urlrule == '') {
			$urlrule = self::urlParse('page={$page}');
		} else {
			$urlrule = self::urlParse($urlrule);
		}

		$multipage = '';
		if ($num > $perpage) {
			$page = $setpages + 1;
			$offset = ceil($setpages / 2 - 1);
			$pages = ceil($num / $perpage);
			if (!defined('PAGE_LIST_SIZE'))
				define('PAGE_LIST_SIZE', $pages);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;
			if ($page >= $pages) {
				$from = 2;
				$to = $pages - 1;
			} else {
				if ($from <= 1) {
					$to = $page - 1;
					$from = 2;
				} elseif ($to >= $pages) {
					$from = $pages - ($page - 2);
					$to = $pages - 1;
				}
				$more = 1;
			}
			$multipage .= '<a class="a1">' . $num . '&nbsp;条</a>';
			if ($curr_page > 0) {
				$multipage .= ' <a href="' . self::pageurl($urlrule, $curr_page - 1, $array) . '" class="a1">上一页</a>';
				if ($curr_page == 1) {
					$multipage .= ' <span>1</span>';
				} elseif ($curr_page > 6 && $more) {
					$multipage .= ' <a href="' . self::pageurl($urlrule, 1, $array) . '">1</a>..';
				} else {
					$multipage .= ' <a href="' . self::pageurl($urlrule, 1, $array) . '">1</a>';
				}
			}
			for ($i = $from; $i <= $to; $i++) {
				if ($i != $curr_page) {
					$multipage .= ' <a href="' . self::pageurl($urlrule, $i, $array) . '">' . $i . '</a>';
				} else {
					$multipage .= ' <span>' . $i . '</span>';
				}
			}
			if ($curr_page < $pages) {
				if ($curr_page < $pages - 5 && $more) {
					$multipage .= ' ..<a href="' . self::pageurl($urlrule, $pages, $array) . '">' . $pages . '</a> <a href="' . self::pageurl($urlrule, $curr_page + 1, $array) . '" class="a1">下一页</a>';
				} else {
					$multipage .= ' <a href="' . self::pageurl($urlrule, $pages, $array) . '">' . $pages . '</a> <a href="' . self::pageurl($urlrule, $curr_page + 1, $array) . '" class="a1">下一页</a>';
				}
			} elseif ($curr_page == $pages) {
				$multipage .= ' <span>' . $pages . '</span> <a href="' . self::pageurl($urlrule, $curr_page, $array) . '" class="a1">下一页</a>';
			} else {
				$multipage .= ' <a href="' . self::pageurl($urlrule, $pages, $array) . '">' . $pages . '</a> <a href="' . self::pageurl($urlrule, $curr_page + 1, $array) . '" class="a1">下一页</a>';
			}
		}
		return $multipage;
	}

	/**
	 * 返回分页路径
	 *
	 * @param $urlrule 分页规则
	 * @param $page 当前页
	 * @param $array 需要传递的数组，用于增加额外的方法
	 * @return 完整的URL路径
	 */
	public static function pageurl($urlrule, $page, $array = array())
	{
		if (strpos($urlrule, '~')) {
			$urlrules = explode('~', $urlrule);
			$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
		}
		$findme = array('{$page}');
		$replaceme = array($page);
		if (is_array($array))
			foreach ($array as $k => $v) {
				$findme[] = '{$' . $k . '}';
				$replaceme[] = $v;
			}
		$url = str_replace($findme, $replaceme, $urlrule);
		$url = str_replace(array('http://', '//', '~'), array('~', '/', 'http://'), $url);
		return $url;
	}

	/**
	 * URL路径解析，pages 函数的辅助函数
	 *
	 * @param $par 传入需要解析的变量 默认为，page={$page}
	 * @param $url URL地址
	 * @return URL
	 */
	public static function urlParse($par, $url = '')
	{
		if ($url == '')
			$url = Func::getUrl();
		$pos = strpos($url, '?');
		if ($pos === false) {
			$url .= '?' . $par;
		} else {
			$querystring = substr(strstr($url, '?'), 1);
			$pars = array();
			parse_str($querystring, $pars);
			$query_array = array();
			foreach ($pars as $k => $v) {
				if ($k != 'page')
					$query_array[$k] = $v;
			}
			$querystring = http_build_query($query_array) . '&' . $par;
			$url = substr($url, 0, $pos) . '?' . $querystring;
		}
		return $url;
	}

}

?>
