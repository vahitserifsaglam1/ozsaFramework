<?php
namespace Mailer;
class Html2Text
{
 protected $html;
 protected $text;
 protected $width = 70;
 protected $search = array(
  "/\r/", 
  "/[\n\t]+/",  
  '/<head[^>]*>.*?<\/head>/i',  
  '/<script[^>]*>.*?<\/script>/i',  
  '/<style[^>]*>.*?<\/style>/i', 
  '/<p[^>]*>/i',
  '/<br[^>]*>/i',  
  '/<i[^>]*>(.*?)<\/i>/i',  
  '/<em[^>]*>(.*?)<\/em>/i',
  '/(<ul[^>]*>|<\/ul>)/i',
  '/(<ol[^>]*>|<\/ol>)/i', 
  '/(<dl[^>]*>|<\/dl>)/i', 
  '/<li[^>]*>(.*?)<\/li>/i',  
  '/<dd[^>]*>(.*?)<\/dd>/i',  
  '/<dt[^>]*>(.*?)<\/dt>/i',  
  '/<li[^>]*>/i', 
  '/<hr[^>]*>/i',  
  '/<div[^>]*>/i', 
  '/(<table[^>]*>|<\/table>)/i', 
  '/(<tr[^>]*>|<\/tr>)/i',  
  '/<td[^>]*>(.*?)<\/td>/i', 
  '/<span class="_html2text_ignore">.+?<\/span>/i'
 );

 protected $replace = array(
  '',
  ' ',  
  '',
  '',
  '',
  "\n\n",  
  "\n", 
  '_\\1_', 
  '_\\1_', 
  "\n\n", 
  "\n\n",  
  "\n\n", 
  "\t* \\1\n", 
  " \\1\n",
  "\t* \\1",
  "\n\t* ",
  "\n-------------------------\n", 
  "<div>\n",
  "\n\n",  
  "\n",
  "\t\t\\1\n",
  "" 
 );

 protected $ent_search = array(
  '/&(nbsp|#160);/i', 
  '/&(quot|rdquo|ldquo|#8220|#8221|#147|#148);/i',
  // Double quotes
  '/&(apos|rsquo|lsquo|#8216|#8217);/i',  
  '/&gt;/i',
  '/&lt;/i',
  '/&(copy|#169);/i',  
  '/&(trade|#8482|#153);/i',  
  '/&(reg|#174);/i', 
  '/&(mdash|#151|#8212);/i',  
  '/&(ndash|minus|#8211|#8722);/i',
  '/&(bull|#149|#8226);/i',
  '/&(pound|#163);/i',  
  '/&(euro|#8364);/i',
  '/&(amp|#38);/i',
  '/[ ]{2,}/',  
 );
 protected $ent_replace = array(
  ' ', 
  '"', 
  "'",
  '>',
  '<',
  '(c)',
  '(tm)',
  '(R)',
  '--',
  '-',
  '*',
  '£',
  'EUR',
  '|+|amp|+|', 
  ' ',
 );

 protected $callback_search = array(
  '/<(a) [^>]*href=("|\')([^"\']+)\2([^>]*)>(.*?)<\/a>/i',
  '/<(h)[123456]( [^>]*)?>(.*?)<\/h[123456]>/i', 
  '/<(b)( [^>]*)?>(.*?)<\/b>/i', 
  '/<(strong)( [^>]*)?>(.*?)<\/strong>/i',
  '/<(th)( [^>]*)?>(.*?)<\/th>/i', 
 );
 protected $pre_search = array(
  "/\n/",
  "/\t/",
  '/ /',
  '/<pre[^>]*>/',
  '/<\/pre>/'
 );
 protected $pre_replace = array(
  '<br>',
  '&nbsp;&nbsp;&nbsp;&nbsp;',
  '&nbsp;',
  '',
  ''
 );

 protected $pre_content = '';
 protected $allowed_tags = '';
 protected $url;
 protected $_converted = false;
 protected $_link_list = array();
 protected $_options = array(
  'do_links' => 'inline',
  'width' => 70
 );

 public function __construct($source = '', $from_file = false, $options = array())
 {
  $this->_options = array_merge($this->_options, $options);

  if (!empty($source)) {
$this->set_html($source, $from_file);
  }

  $this->set_base_url();
 }
 public function set_html($source, $from_file = false)
 {
  if ($from_file && file_exists($source)) {
$this->html = file_get_contents($source);
  } else {
$this->html = $source;
  }

  $this->_converted = false;
 }
 public function get_text()
 {
  if (!$this->_converted) {
$this->_convert();
  }

  return $this->text;
 }
 public function print_text()
 {
  print $this->get_text();
 }
 public function p()
 {
  print $this->get_text();
 }

 public function set_allowed_tags($allowed_tags = '')
 {
  if (!empty($allowed_tags)) {
$this->allowed_tags = $allowed_tags;
  }
 }

 public function set_base_url($url = '')
 {
  if (empty($url)) {
if (!empty($_SERVER['HTTP_HOST'])) {
 $this->url = 'http://' . $_SERVER['HTTP_HOST'];
} else {
 $this->url = '';
}
  } else {
if (substr($url, -1) == '/') {
 $url = substr($url, 0, -1);
}
$this->url = $url;
  }
 }
 protected function _convert()
 {
  $this->_link_list = array();
  $text = trim(stripslashes($this->html));
  $this->_converter($text);
  if (!empty($this->_link_list)) {
$text .= "\n\nLinks:\n------\n";
foreach ($this->_link_list as $idx => $url) {
 $text .= '[' . ($idx + 1) . '] ' . $url . "\n";
}
  }
  $this->text = $text;
  $this->_converted = true;
 }
 protected function _converter(&$text)
 {
  $this->_convert_blockquotes($text);
  $this->_convert_pre($text);
  $text = preg_replace($this->search, $this->replace, $text);
  $text = preg_replace_callback($this->callback_search, array($this, '_preg_callback'), $text);
  $text = strip_tags($text, $this->allowed_tags);
  $text = preg_replace($this->ent_search, $this->ent_replace, $text);
  $text = html_entity_decode($text, ENT_QUOTES);
  $text = preg_replace('/&([a-zA-Z0-9]{2,6}|#[0-9]{2,4});/', '', $text);
  $text = str_replace('|+|amp|+|', '&', $text);
  $text = preg_replace("/\n\s+\n/", "\n\n", $text);
  $text = preg_replace("/[\n]{3,}/", "\n\n", $text);
  $text = ltrim($text, "\n");
  if ($this->_options['width'] > 0) {
$text = wordwrap($text, $this->_options['width']);
  }
 }
 protected function _build_link_list($link, $display, $link_override = null)
 {
  $link_method = ($link_override) ? $link_override : $this->_options['do_links'];
  if ($link_method == 'none') {
return $display;
  }
  if (preg_match('!^(javascript:|mailto:|#)!i', $link)) {
return $display;
  }

  if (preg_match('!^([a-z][a-z0-9.+-]+:)!i', $link)) {
$url = $link;
  } else {
$url = $this->url;
if (substr($link, 0, 1) != '/') {
 $url .= '/';
}
$url .= "$link";
  }

  if ($link_method == 'table') {
if (($index = array_search($url, $this->_link_list)) === false) {
 $index = count($this->_link_list);
 $this->_link_list[] = $url;
}

return $display . ' [' . ($index + 1) . ']';
  } elseif ($link_method == 'nextline') {
return $display . "\n[" . $url . ']';
  } else { 

return $display . ' [' . $url . ']';
  }
 }
 protected function _convert_pre(&$text)
 {
  while (preg_match('/<pre[^>]*>(.*)<\/pre>/ismU', $text, $matches)) {
$this->pre_content = $matches[1];
$this->pre_content = preg_replace_callback(
 $this->callback_search,
 array($this, '_preg_callback'),
 $this->pre_content
);
$this->pre_content = sprintf(
 '<div><br>%s<br></div>',
 preg_replace($this->pre_search, $this->pre_replace, $this->pre_content)
);
$text = preg_replace_callback(
 '/<pre[^>]*>.*<\/pre>/ismU',
 array($this, '_preg_pre_callback'),
 $text,
 1
);
$this->pre_content = '';
  }
 }
 protected function _convert_blockquotes(&$text)
 {
  if (preg_match_all('/<\/*blockquote[^>]*>/i', $text, $matches, PREG_OFFSET_CAPTURE)) {
$start = 0;
$taglen = 0;
$level = 0;
$diff = 0;
foreach ($matches[0] as $m) {
 if ($m[0][0] == '<' && $m[0][1] == '/') {
  $level--;
  if ($level < 0) {
$level = 0; 
  } elseif ($level > 0) {
  } else {
$end = $m[1];
$len = $end - $taglen - $start;
$body = substr($text, $start + $taglen - $diff, $len);
$p_width = $this->_options['width'];
if ($this->_options['width'] > 0) $this->_options['width'] -= 2;
$body = trim($body);
$this->_converter($body);
$body = preg_replace('/((^|\n)>*)/', '\\1> ', trim($body));
$body = '<pre>' . htmlspecialchars($body) . '</pre>';
$this->_options['width'] = $p_width;
$text = substr($text, 0, $start - $diff)
 . $body . substr($text, $end + strlen($m[0]) - $diff);
$diff = $len + $taglen + strlen($m[0]) - strlen($body);
unset($body);
  }
 } else {
  if ($level == 0) {
$start = $m[1];
$taglen = strlen($m[0]);
  }
  $level++;
 }
}
  }
 }
 protected function _preg_callback($matches)
 {
  switch (strtolower($matches[1])) {
case 'b':
case 'strong':
 return $this->_toupper($matches[3]);
case 'th':
 return $this->_toupper("\t\t" . $matches[3] . "\n");
case 'h':
 return $this->_toupper("\n\n" . $matches[3] . "\n\n");
case 'a':
 $link_override = null;
 if (preg_match('/_html2text_link_(\w+)/', $matches[4], $link_override_match)) {
  $link_override = $link_override_match[1];
 }
 $url = str_replace(' ', '', $matches[3]);

 return $this->_build_link_list($url, $matches[5], $link_override);
  }
  return '';
 }
 protected function _preg_pre_callback(
  $matches)
 {
  return $this->pre_content;
 }
 private function _toupper($str)
 {
  $chunks = preg_split('/(<[^>]*>)/', $str, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
  foreach ($chunks as $idx => $chunk) {
if ($chunk[0] != '<') {
 $chunks[$idx] = $this->_strtoupper($chunk);
}
  }

  return implode($chunks);
 }
 private function _strtoupper($str)
 {
  $str = html_entity_decode($str, ENT_COMPAT);

  if (function_exists('mb_strtoupper'))
$str = mb_strtoupper($str, 'UTF-8');
  else
$str = strtoupper($str);

  $str = htmlspecialchars($str, ENT_COMPAT);

  return $str;
 }
}
