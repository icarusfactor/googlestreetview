<?php
/**
 * MediaWiki Extension
 * {{php}}{{Category:Extensions| gstreetview  }}
 * @package MediaWiki
 * @subpackage Extensions
 * @licence GNU General Public Licence 2.0 or later
 */
 
define('GOOGLESTREETVIEW_VERSION','0.0');
 
$wgExtensionFunctions[] = 'wfSetupGoogleStreetView';
$wgHooks['LanguageGetMagic'][] = 'wfGoogleStreetViewLanguageGetMagic';




 
$wgExtensionCredits['parserhook'][] = array(
        'name'        => 'Google Street View',
        'author'      => 'Daniel Yount - icarusfactor',
        'description' => 'Google StreetView Extension',
        'url'         => 'http://www.mediawiki.org',
        'version'     => GOOGLESTREETVIEW_VERSION
);
 
function wfGoogleStreetViewLanguageGetMagic(&$magicWords,$langCode = 0) {
        $magicWords['gstreetview'] = array(0,'gstreetview');
        return true;
}
 
function wfSetupGoogleStreetView() {
        global $wgParser;
        $wgParser->setFunctionHook('gstreetview','wfRenderGoogleStreetView');
        return true;
}
 
# Renders a table of all the individual month tables
function wfRenderGoogleStreetView( &$parser) {
        $output = '';

        #$parser->mOutput->mCacheTime = -1;
        $argv = array();
        foreach (func_get_args() as $arg) if (!is_object($arg)) {
                if (preg_match('/^(.+?)\\s*=\\s*(.+)$/',$arg,$match)) $argv[$match[1]]=$match[2];
        }
        if (isset($argv['lat']))    $lat  = $argv['lat']; else $lat = '0,0';
        if (isset($argv['lon']))      $lon  = $argv['lon'];  else $lon  = '0.0';
        if (isset($argv['rot']))     $rot = $argv['rot']; else $rot = '0.00';
        if (isset($argv['width']))     $width = $argv['width']; else $width = '400';
        if (isset($argv['height']))     $height = $argv['height']; else $height = '400';

        
        
        $locate = str_replace( ' ' , '%20' , urlencode( $channel ) );

        $output =  '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?layer=c&cbll='.$lat.','.$lon.'&cbp=12,'.$rot.',,0,5&output=svembed&ll='.$lat.','.$lon.'"></iframe>'; 

        return $parser->insertStripItem( $output, $parser->mStripState );
        #return $output;


}