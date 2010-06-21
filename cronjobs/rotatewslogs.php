<?php
/**
 * Rotate logs of ws calls: since we store them in the per-sa dir, eZ will not do it on its own.
 *
 * We are very nice people, and allow a custom max file size to be specified
 * instead of relying on eZ default one, and a number of rotated files to be kept, too!
 *
 * @author G. Giunta
 * @version $Id: checkusers.php 368 2009-07-01 13:05:03Z CPTICD1 $
 * @copyright (C) G. Giunta 2009-2010
 */

$ini = eZINI::instance( 'wsproviders.ini' );
$maxFileSize = $ini->variable( 'GeneralSettings', 'MaxLogSize' );
if ( $maxFileSize <= 0 )
{
    // in case ini setting is missing
    $maxFileSize = eZDebug::maxLogSize();
}
if ( $ini->hasVariable( 'GeneralSettings', 'MaxLogrotateFiles' ) && $ini->variable( 'GeneralSettings', 'MaxLogrotateFiles' ) > 0 )
{
    $defaultrotate = eZDebug::maxLogrotateFiles();
    eZDebug::setLogrotateFiles( $ini->variable( 'GeneralSettings', 'MaxLogrotateFiles' ) );
}

$varDir = eZSys::varDirectory();
$logDir = 'log';
$logName = 'webservices.log';
$fileName = $varDir . '/' . $logDir . '/' . $logName;

if ( file_exists( $fileName ) && filesize( $fileName ) > $maxFileSize )
{
    eZDebug::rotateLog( $fileName );
}

if ( isset( $defaultrotate ) )
{
    eZDebug::setLogrotateFiles( $defaultrotate );
}

?>