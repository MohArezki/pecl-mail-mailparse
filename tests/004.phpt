--TEST--
Check uudecode_all
--SKIPIF--
<?php
/* vim600: sw=4 ts=4 fdm=marker syn=php
*/
if (!extension_loaded("mailparse")) @dl("mailparse.so");
if (!extension_loaded("mailparse")) print "skip"; ?>
--POST--
--GET--
--FILE--
<?php
if (!extension_loaded("mailparse")) @dl("mailparse.so");
$text = <<<EOD
To: fred@bloggs.com

hello, this is some text hello.
blah blah blah.

begin 644 test.txt
/=&AI<R!I<R!A('1E<W0*
`
end

EOD;

$fp = tmpfile();
fwrite($fp, $text);

$data = mailparse_uudecode_all($fp);

echo "BODY\n";
readfile($data[0]["filename"]);
echo "UUE\n";
readfile($data[1]["filename"]);

unlink($data[0]["filename"]);
unlink($data[1]["filename"]);

?>
--EXPECT--
BODY
To: fred@bloggs.com

hello, this is some text hello.
blah blah blah.

UUE
this is a test
