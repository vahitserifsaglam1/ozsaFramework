<?php
class cURL {
 public $pause_interval;
 public $threads;
 private $_htmlentities;
 private $_info;
 private $_queue;
 private $_multi_handle;
 private $_response_messages = array(
  0=>  'CURLE_OK',
  1=>  'CURLE_UNSUPPORTED_PROTOCOL',
  2=>  'CURLE_FAILED_INIT',
  3=>  'CURLE_URL_MALFORMAT',
  4=>  'CURLE_URL_MALFORMAT_USER',
  5=>  'CURLE_COULDNT_RESOLVE_PROXY',
  6=>  'CURLE_COULDNT_RESOLVE_HOST',
  7=>  'CURLE_COULDNT_CONNECT',
  8=>  'CURLE_FTP_WEIRD_SERVER_REPLY',
  9=>  'CURLE_REMOTE_ACCESS_DENIED',
  11  =>  'CURLE_FTP_WEIRD_PASS_REPLY',
  13  =>  'CURLE_FTP_WEIRD_PASV_REPLY',
  14  =>  'CURLE_FTP_WEIRD_227_FORMAT',
  15  =>  'CURLE_FTP_CANT_GET_HOST',
  17  =>  'CURLE_FTP_COULDNT_SET_TYPE',
  18  =>  'CURLE_PARTIAL_FILE',
  19  =>  'CURLE_FTP_COULDNT_RETR_FILE',
  21  =>  'CURLE_QUOTE_ERROR',
  22  =>  'CURLE_HTTP_RETURNED_ERROR',
  23  =>  'CURLE_WRITE_ERROR',
  25  =>  'CURLE_UPLOAD_FAILED',
  26  =>  'CURLE_READ_ERROR',
  27  =>  'CURLE_OUT_OF_MEMORY',
  28  =>  'CURLE_OPERATION_TIMEDOUT',
  30  =>  'CURLE_FTP_PORT_FAILED',
  31  =>  'CURLE_FTP_COULDNT_USE_REST',
  33  =>  'CURLE_RANGE_ERROR',
  34  =>  'CURLE_HTTP_POST_ERROR',
  35  =>  'CURLE_SSL_CONNECT_ERROR',
  36  =>  'CURLE_BAD_DOWNLOAD_RESUME',
  37  =>  'CURLE_FILE_COULDNT_READ_FILE',
  38  =>  'CURLE_LDAP_CANNOT_BIND',
  39  =>  'CURLE_LDAP_SEARCH_FAILED',
  41  =>  'CURLE_FUNCTION_NOT_FOUND',
  42  =>  'CURLE_ABORTED_BY_CALLBACK',
  43  =>  'CURLE_BAD_FUNCTION_ARGUMENT',
  45  =>  'CURLE_INTERFACE_FAILED',
  47  =>  'CURLE_TOO_MANY_REDIRECTS',
  48  =>  'CURLE_UNKNOWN_TELNET_OPTION',
  49  =>  'CURLE_TELNET_OPTION_SYNTAX',
  51  =>  'CURLE_PEER_FAILED_VERIFICATION',
  52  =>  'CURLE_GOT_NOTHING',
  53  =>  'CURLE_SSL_ENGINE_NOTFOUND',
  54  =>  'CURLE_SSL_ENGINE_SETFAILED',
  55  =>  'CURLE_SEND_ERROR',
  56  =>  'CURLE_RECV_ERROR',
  58  =>  'CURLE_SSL_CERTPROBLEM',
  59  =>  'CURLE_SSL_CIPHER',
  60  =>  'CURLE_SSL_CACERT',
  61  =>  'CURLE_BAD_CONTENT_ENCODING',
  62  =>  'CURLE_LDAP_INVALID_URL',
  63  =>  'CURLE_FILESIZE_EXCEEDED',
  64  =>  'CURLE_USE_SSL_FAILED',
  65  =>  'CURLE_SEND_FAIL_REWIND',
  66  =>  'CURLE_SSL_ENGINE_INITFAILED',
  67  =>  'CURLE_LOGIN_DENIED',
  68  =>  'CURLE_TFTP_NOTFOUND',
  69  =>  'CURLE_TFTP_PERM',
  70  =>  'CURLE_REMOTE_DISK_FULL',
  71  =>  'CURLE_TFTP_ILLEGAL',
  72  =>  'CURLE_TFTP_UNKNOWNID',
  73  =>  'CURLE_REMOTE_FILE_EXISTS',
  74  =>  'CURLE_TFTP_NOSUCHUSER',
  75  =>  'CURLE_CONV_FAILED',
  76  =>  'CURLE_CONV_REQD',
  77  =>  'CURLE_SSL_CACERT_BADFILE',
  78  =>  'CURLE_REMOTE_FILE_NOT_FOUND',
  79  =>  'CURLE_SSH',
  80  =>  'CURLE_SSL_SHUTDOWN_FAILED',
  81  =>  'CURLE_AGAIN',
  82  =>  'CURLE_SSL_CRL_BADFILE',
  83  =>  'CURLE_SSL_ISSUER_ERROR',
  84  =>  'CURLE_FTP_PRET_FAILED',
  85  =>  'CURLE_RTSP_CSEQ_ERROR',
  86  =>  'CURLE_RTSP_SESSION_ERROR',
  87  =>  'CURLE_FTP_BAD_FILE_LIST',
  88  =>  'CURLE_CHUNK_FAILED',
 );
 function __construct($htmlentities = true)
 {
  if (!extension_loaded('curl')) trigger_error('php_curl extension is not loaded!', E_USER_ERROR);
  $this->ssl();
  $this->_multi_handle = false;
  $this->_info = array();
  $this->cache(false);
  $this->pause_interval = 0;
  $this->threads = 10;
  $this->_htmlentities = $htmlentities;
 }
 public function cache($path, $lifetime = 3600, $compress = true, $chmod = 0755)
 {
  if ($path != false)
$this->cache = array(
 'path'=>  $path,
 'lifetime'  =>  $lifetime,
 'chmod'  =>  $chmod,
 'compress'  =>  $compress,
);
  else $this->cache = false;
 }
 public function cookies($path, $keep = false)
 {
  if (!is_file($path)) {
if (!($handle = fopen($path, 'a')))
 trigger_error('File "' . $path . '" for storing cookies could not be found nor could it automatically be created! Make sure either that the path to the file points to a writable directory, or create the file yourself and make it writable.', E_USER_ERROR);
fclose($handle);
  }
  $this->option(array(
CURLOPT_COOKIEJAR=>  $path,
CURLOPT_COOKIEFILE  =>  $path,
  ));
 }
 public function download($url, $destination_path, $callback = '')
 {
  if (!is_dir($destination_path) || !is_writable($destination_path)) trigger_error('"' . $destination_path . '" is not a valid path or is not writable!', E_USER_ERROR);
  $this->download_path = rtrim($destination_path, '/\\') . '/';
  $this->option(array(
CURLINFO_HEADER_OUT  =>  1,
CURLOPT_BINARYTRANSFER  =>  1,
CURLOPT_HEADER =>  1,
CURLOPT_FILE=>  null,
CURLOPT_HTTPGET=>  null,
CURLOPT_NOBODY =>  null,
CURLOPT_POST=>  null,
CURLOPT_POSTFIELDS=>  null,
CURLOPT_USERPWD=>  null,
  ));
  $arguments = func_get_args();
  $arguments = array_merge(array($url, $callback), array_slice($arguments, 3));
  call_user_func_array(array($this, $this->pause_interval > 0 ? '_process_paused' : '_process'), $arguments);
 }
 public function ftp_download($url, $destination_path, $username = '', $password = '', $callback = '')
 {
  if ($username != '') $this->option(CURLOPT_USERPWD, $username . ':' . $password);
  $this->option(array(
CURLINFO_HEADER_OUT  =>  1,
CURLOPT_BINARYTRANSFER  =>  1,
CURLOPT_HEADER =>  1,
CURLOPT_HTTPGET=>  null,
CURLOPT_FILE=>  null,
CURLOPT_NOBODY =>  null,
CURLOPT_POST=>  null,
CURLOPT_POSTFIELDS=>  null,
CURLOPT_USERPWD=>  null,
  ));
  $arguments = func_get_args();
  $arguments = array_merge(array($url, $destination_path, $callback), array_slice($arguments, 5));
  call_user_func_array(array($this, 'download'), $arguments);
 }
 public function get($url, $callback = '')
 {
		$this->option(array(
CURLINFO_HEADER_OUT  =>  1,
CURLOPT_HEADER =>  1,
CURLOPT_HTTPGET=>  1,
CURLOPT_NOBODY =>  0,
CURLOPT_BINARYTRANSFER  =>  null,
CURLOPT_FILE=>  null,
CURLOPT_POST=>  null,
CURLOPT_POSTFIELDS=>  null,
CURLOPT_USERPWD=>  null,
  ));
  $arguments = func_get_args();
  call_user_func_array(array($this, $this->pause_interval > 0 ? '_process_paused' : '_process'), $arguments);

 }
 public function header($url, $callback = '')
 {
  $this->option(array(
CURLINFO_HEADER_OUT  =>  1,
CURLOPT_HEADER =>  1,
CURLOPT_HTTPGET=>  1,
CURLOPT_NOBODY =>  1,
CURLOPT_BINARYTRANSFER  =>  null,
CURLOPT_FILE=>  null,
CURLOPT_POST=>  null,
CURLOPT_POSTFIELDS=>  null,
CURLOPT_USERPWD=>  null,
  ));
  $arguments = func_get_args();
  call_user_func_array(array($this, $this->pause_interval > 0 ? '_process_paused' : '_process'), $arguments);
 }
 public function http_authentication($username, $password, $type = CURLAUTH_ANY)
 {
		$this->option(array(
CURLOPT_HTTPAUTH =>  $type,
CURLOPT_USERPWD  =>  $username . ':' . $password,
  ));
 }
 public function option($option, $value = '')
 {
  if (is_array($option))
foreach ($option as $name => $value)
 if (is_null($value)) unset($this->options[$name]);
 else $this->options[$name] = $value;
  elseif (is_null($value)) unset($this->options[$option]);
  else $this->options[$option] = $value;
 }
 public function post($url, $values, $callback = '')
 {
  if (!is_array($values)) trigger_error('Second argument to method "post" must be an array!', E_USER_ERROR);
  $this->option(array(
CURLINFO_HEADER_OUT  =>  1,
CURLOPT_HEADER =>  1,
CURLOPT_NOBODY =>  0,
CURLOPT_POST=>  1,
CURLOPT_POSTFIELDS=>  http_build_query($values, NULL, '&'),
CURLOPT_BINARYTRANSFER  =>  null,
CURLOPT_HTTPGET=>  null,
CURLOPT_FILE=>  null,
CURLOPT_USERPWD=>  null,
  ));
  $arguments = func_get_args();
  unset($arguments[1]);
  call_user_func_array(array($this, $this->pause_interval > 0 ? '_process_paused' : '_process'), $arguments);

 }
 public function proxy($proxy, $port = 80, $username = '', $password = '')
 {
  if ($proxy) {
$this->option(array(
 CURLOPT_HTTPPROXYTUNNEL  =>  1,
 CURLOPT_PROXY=>  $proxy,
 CURLOPT_PROXYPORT  =>  $port,
));
if ($username != '')
 $this->option(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
  } else
$this->option(array(
 CURLOPT_HTTPPROXYTUNNEL  =>  null,
 CURLOPT_PROXY=>  null,
 CURLOPT_PROXYPORT  =>  null,
));

 }

 public function ssl($verify_peer = false, $verify_host = 2, $file = false, $path = false)
 {
  $this->option(array(
  	CURLOPT_SSL_VERIFYPEER => $verify_peer,
  	CURLOPT_SSL_VERIFYHOST => $verify_host,
  ));
  if ($file !== false)
if (is_file($file)) $this->option(CURLOPT_CAINFO, $file);
else trigger_error('File "' . $file . '", holding one or more certificates to verify the peer with, was not found!', E_USER_ERROR);
  if ($path !== false)
if (is_dir($path)) $this->option(CURLOPT_CAPATH, $path);
else trigger_error('Directory "' . $path . '", holding one or more CA certificates to verify the peer with, was not found!', E_USER_ERROR);

 }
 private function _debug()
 {

  $result = '';
  foreach(get_defined_constants() as $name => $number)
foreach ($this->options as $index => $value)
 if (substr($name, 0, 7) == 'CURLOPT' && $number == $index) $result .= $name . ' => ' . $value . '<br>';
  return $result;
 }
 private function _parse_headers($headers)
 {
  $result = array();
  if ($headers != '') {
$headers = preg_split('/^\s*$/m', trim($headers));
foreach($headers as $index => $header) {
 $arguments_count = func_num_args();
 preg_match_all('/^(.*?)\:\s(.*)$/m', ($arguments_count == 2 ? 'Request Method: ' : 'Status: ') . trim($header), $matches);
 foreach ($matches[0] as $key => $value)
  $result[$index][$matches[1][$key]] = trim($matches[2][$key]);

}
  }
  return $result;

 }
 private function _process($urls, $callback = '')
 {
  if ($this->cache !== false && (!is_dir($this->cache['path']) || !is_writable($this->cache['path'])))
trigger_error('Cache path does not exists or is not writable!', E_USER_ERROR);
  if ($callback != '' && !is_callable($callback))
trigger_error('Callback function "' . $callback . '" does not exist!', E_USER_ERROR);
  $urls = !is_array($urls) ? (array)$urls : $urls;

  if (
$this->cache !== false &&
 ((isset($this->options[CURLOPT_HTTPGET]) && $this->options[CURLOPT_HTTPGET] == 1) ||
 (isset($this->options[CURLOPT_POST]) && $this->options[CURLOPT_POST] == 1))

  ) {
foreach ($urls as $url) {
 $cache_path = rtrim($this->cache['path'], '/') . '/' . md5($url . (isset($this->options[CURLOPT_POSTFIELDS]) ? serialize($this->options[CURLOPT_POSTFIELDS]) : ''));
 if (file_exists($cache_path) && filemtime($cache_path) + $this->cache['lifetime'] > time()) {
  if ($callback != '') {
$arguments = func_get_args();
$arguments = array_merge(
 array(unserialize($this->cache['compress'] ? gzuncompress(file_get_contents($cache_path)) : file_get_contents($cache_path))),
 array_slice($arguments, 2)

);
call_user_func_array($callback, $arguments);
  }
 } else $this->_queue[] = $url;

}
  } else $this->_queue = $urls;
  if (!empty($this->_queue)) {
$this->_multi_handle = curl_multi_init();
$this->_queue_requests();
$running = null;
do {
 while (($status = curl_multi_exec($this->_multi_handle, $running)) == CURLM_CALL_MULTI_PERFORM);
 if ($status != CURLM_OK) break;
 while ($info = curl_multi_info_read($this->_multi_handle)) {
  $handle = $info['handle'];
  $content = curl_multi_getcontent($handle);
  $resource_number = preg_replace('/Resource id #/', '', $handle);
  $result = new stdClass();
  $result->info = curl_getinfo($handle);
  $result->info = array('original_url' => $this->_info['fh' . $resource_number]['original_url']) + $result->info;
  $result->headers['last_request'] =

(
 isset($this->options[CURLINFO_HEADER_OUT]) &&
 $this->options[CURLINFO_HEADER_OUT] == 1 &&
 isset($result->info['request_header'])
) ? $this->_parse_headers($result->info['request_header'], true) : '';
  unset($result->info['request_header']);
  $result->headers['responses'] = (isset($this->options[CURLOPT_HEADER]) && $this->options[CURLOPT_HEADER] == 1) ?
$this->_parse_headers(substr($content, 0, $result->info['header_size'])) :
'';
  $result->body = !isset($this->options[CURLOPT_NOBODY]) || $this->options[CURLOPT_NOBODY] == 0 ?
(isset($this->options[CURLOPT_HEADER]) && $this->options[CURLOPT_HEADER] == 1 ?
substr($content, $result->info['header_size']) :
$content) :

'';
  if ($result->body != '' && !isset($this->options[CURLOPT_BINARYTRANSFER]) && $this->_htmlentities) {
if (defined(ENT_IGNORE)) $result->body = htmlentities($result->body, ENT_IGNORE, 'utf-8');
else htmlentities($result->body);
  }

  $result->response = array($this->_response_messages[$info['result']], $info['result']);
  if ($callback != '') {
$arguments = func_get_args();
$arguments = array_merge(
 array($result),
 array_slice($arguments, 2)
);
$callback_response = call_user_func_array($callback, $arguments);
  } else $callback_response = true;
  if (
$this->cache !== false &&
$callback_response !== false &&
 ((isset($this->options[CURLOPT_HTTPGET]) && $this->options[CURLOPT_HTTPGET] == 1) ||
 (isset($this->options[CURLOPT_POST]) && $this->options[CURLOPT_POST] == 1))
  ) {
$cache_path = rtrim($this->cache['path'], '/') . '/' . md5($result->info['original_url'] . (isset($this->options[CURLOPT_POSTFIELDS]) ? serialize($this->options[CURLOPT_POSTFIELDS]) : ''));
file_put_contents($cache_path, $this->cache['compress'] ? gzcompress(serialize($result)) : serialize($result));
chmod($cache_path, intval($this->cache['chmod'], 8));
  }
  if (!empty($this->_queue)) $this->_queue_requests();
  curl_multi_remove_handle($this->_multi_handle, $handle);
  curl_close($handle);
  if (isset($this->options[CURLOPT_BINARYTRANSFER]) && $this->options[CURLOPT_BINARYTRANSFER])
fclose($this->_info['fh' . $resource_number]['file_handler']);
  unset($this->_info['fh' . $resource_number]);

 }
 if ($running && curl_multi_select($this->_multi_handle) === -1) usleep(100);
} while ($running);
curl_multi_close($this->_multi_handle);
  }
 }
 private function _process_paused($urls, $callback = '') {
  while (!empty($urls)) {
$urls_to_process = array_splice($urls, 0, $this->threads, array());
$this->_process($urls_to_process, $callback);
sleep($this->pause_interval);
  }
 }

 private function _queue_requests()
 {
  $queue_length = count($this->_queue);
  for ($i = 0; $i < ($queue_length < $this->threads ? $queue_length : $this->threads); $i++) {
$url = array_shift($this->_queue);
$handle = curl_init($url);
$this->_set_defaults();
$resource_number = preg_replace('/Resource id #/', '', $handle);
$this->_info['fh' . $resource_number]['original_url'] = $url;
if (isset($this->options[CURLOPT_BINARYTRANSFER]) && $this->options[CURLOPT_BINARYTRANSFER]) {
 $this->_info['fh' . $resource_number]['file_handler'] = fopen($this->download_path . basename($url), 'w');
 $this->option(CURLOPT_HEADER, 0);
 $this->option(CURLOPT_FILE, $this->_info['fh' . $resource_number]['file_handler']);
}
curl_setopt_array($handle, $this->options);
curl_multi_add_handle($this->_multi_handle, $handle);
  }
 }
 private function _set_defaults()
 {
  if (!isset($this->options[CURLINFO_HEADER_OUT])) $this->option(CURLINFO_HEADER_OUT, 1);
  if (!isset($this->options[CURLOPT_AUTOREFERER])) $this->option(CURLOPT_AUTOREFERER, 1);
  if (!isset($this->options[CURLOPT_COOKIEFILE])) $this->option(CURLOPT_COOKIEFILE, '');
  if (!isset($this->options[CURLOPT_CONNECTTIMEOUT])) $this->option(CURLOPT_CONNECTTIMEOUT, 10);
  if (!isset($this->options[CURLOPT_ENCODING])) $this->option(CURLOPT_ENCODING, 'gzip,deflate');
  if (!isset($this->options[CURLOPT_FOLLOWLOCATION])) $this->option(CURLOPT_FOLLOWLOCATION, 1);
  if (!isset($this->options[CURLOPT_HEADER])) $this->option(CURLOPT_HEADER, 1);
  if (!isset($this->options[CURLOPT_MAXREDIRS])) $this->option(CURLOPT_MAXREDIRS, 50);
  if (!isset($this->options[CURLOPT_TIMEOUT])) $this->option(CURLOPT_TIMEOUT, 30);
  if (!isset($this->options[CURLOPT_USERAGENT])) $this->option(CURLOPT_USERAGENT, $this->_user_agent());
  $this->option(CURLOPT_RETURNTRANSFER, 1);

 }
 private function _user_agent()
 {
  $version = rand(9, 10);
  $major_version = 6;
  $minor_version =
$version == 8 || $version == 9 ? rand(0, 2) :
2;
  $extras = rand(0, 3);
  return 'Mozilla/5.0 (compatible; MSIE ' . $version . '.0; Windows NT ' . $major_version . '.' . $minor_version . ($extras == 1 ? '; WOW64' : ($extras == 2 ? '; Win64; IA64' : ($extras == 3 ? '; Win64; x64' : ''))) . ')';
 }
}
?>