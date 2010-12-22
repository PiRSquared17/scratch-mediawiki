<?php
/**
 * It's an extension allows you to embed scratch applets in your wiki page
 * the syntax is the following
 * <scratch author="yourname", script="id_of_your_scratch_project", view="java">
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
  echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
  require_once( "\$IP/extensions/Scratch/Scratch.php" );
EOT;
  exit( 1 );
}
$wgExtensionCredits['tag'][] = array(
  'name' => 'Scratch',
  'author' => 'Yury Katkov',
  'url' => 'http://www.mediawiki.org/wiki/Extension:Scratch',
  'description' => 'Allows one to embed scratch scripts into wiki page',
  'descriptionmsg' => 'scratch-desc',  
  'version' => '0.0.1',
);

$wgHooks['ParserFirstCallInit'][] = 'efScratchParserInit';

function efScratchParserInit( &$parser ) {
  $parser->setHook( 'scratch', 'efScratchRender' );
  return true;
}

function efScratchRender( $input, $args, $parser, $frame ) {
$errWrongParameters = 'you should use scratch tag that way:< scratch script="author/id" />';
  if (!isset($args['script']))
    return $errWrongParameters;
  $parser->disableCache();
  $text = "<applet id='ProjectApplet' style='display:block' code='ScratchApplet' codebase='http://scratch.mit.edu/static/misc' archive='ScratchApplet.jar' height='387' width='482'><param name='project' value='../../static/projects/" . $args['script'] . ".sb'></applet> <a href='http://scratch.mit.edu/projects/" . $args['script'] . "'>Еще об этом проекте</a>";

  return $text;
}

