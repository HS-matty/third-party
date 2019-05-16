<?php
//
// This is the index_webdav.php file. Manages WebDAV sessions.
//
// Created on: <18-Aug-2003 15:15:15 bh>
//
// Copyright (C) 1999-2004 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ publish professional licence" version 2
// may use this file in accordance with the "eZ publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.

//
include_once( "lib/ezwebdav/classes/ezwebdavserver.php" );
include_once( "lib/ezutils/classes/ezmimetype.php" );




// Get and return the files/dir-names that reside at a given path.
function getDirEntries( $targetPath )
{
    $files = array();

    // Attempt to open the target dir for listing.
    if ( $handle = opendir( $targetPath ) )
    {
        // For all entries in target dir: get filename.
        while ( false !== ( $file = readdir( $handle ) ) )
        {
            if ( $file != "." && $file != ".." )
            {
                $files[] = $file;
            }
        }
        closedir( $handle );
    }
    // Else: unable to open the dir for listing, bail out...
    else
    {
        return( FALSE );
    }

    // Return array of filenames.
    return $files;
}



// Recursively copies the contents of a directory.
function copyDir( $source, $destination )
{
    // Attempt to create destination dir.
    $status = mkdir( $destination );

    // If no success: bail out.
    if ( !$status )
    {
        return( FALSE );
    }

    // Get the contents of the directory.
    $entries = getDirEntries( $source );

    // Bail if contents is unavailable.
    if ( $entries == FALSE )
    {
        return (FALSE );
    }
    // Else: contents is OK:
    else
    {
        // Copy each and every entry:
        foreach ( $entries as $entry )
        {
            if ( $entry )
            {
                $from = "$source/$entry";
                $to   = "$destination/$entry";

                // Is this a directory? -> special case.
                if ( is_dir( $from ) )
                {
                    $status = copyDir( $from, $to );
                    if (!$status)
                    {
                        return( FALSE );
                    }
                }
                // Else: simple file case.
                else
                {
                    $status = copy( $from, $to );
                    if (!$status)
                    {
                        return( FALSE );
                    }
                }
            }
        }

    }

    // Phew: if we got this far then everything is OK.
    return( TRUE );
}




// Recursively deletes the contents of a directory.
function delDir( $dir )
{
    // Attempt to open the target dir.
    $currentDir = opendir($dir);

    // Bail if unable to open dir.
    if ( $currentDir == FALSE )
    {
        return( FALSE );
    }
    // Else, dir is available, do the thing:
    else
    {
        // For all entires in the dir:
        while($entry = readdir($currentDir))
        {
            // If entry is a directory and not . && .. :
            if ( is_dir( "$dir/$entry" ) and
                 ( $entry != "." and $entry!="..") )
            {
                // Delete the dir.
                $status = deldir( "${dir}/${entry}" );

                // Bail if unable to delete the dir.
                if ( !$status )
                {
                    return( FALSE );
                }
            }
            // Else: not dir but plain file.
            elseif ( $entry != "." and $entry != ".." )
            {
                // Simply unlink the file.
                $status = unlink( "${dir}/${entry}" );

                // Bail if unable to delete the file.
                if ( !$status )
                {
                    return( FALSE );
                }
            }
        }
    }

    // We're finished going through the contents of the target dir.
    closedir( $currentDir );

    // Attempt to remove the target dir itself & return status (should be
    // OK as soon as we get this far...
    $status = rmdir( ${dir} );

    return( $status );
}




/* getFileInfo
   Gathers information about a specific file,
   stores it in an associative array and returns it.
 */
function getFileInfo( $dir, $file )
{
    append_to_log( "inside getFileInfo, dir: $dir, file: $file");
    $realPath = $dir.'/'.$file;
    $fileInfo = array();

    $fileInfo["name"] = $file;

    // If the file is a directory:
    if ( is_dir( $realPath ) )
    {
        $fileInfo["size"]     = 0;
        $fileInfo["mimetype"] = "httpd/unix-directory";

        // Get the dir's creation & modification times.
        $fileInfo["ctime"] = filectime( $realPath.'/.' );
        $fileInfo["mtime"] = filemtime( $realPath.'/.' );

    }
    // Else: The file is an actual file (not a dir):
    else
    {
        // Get the file's creation & modification times.
        $fileInfo["ctime"] = filectime( $realPath );
        $fileInfo["mtime"] = filemtime( $realPath );

        // Get the file size (bytes).
        $fileInfo["size"] = filesize( $realPath );

        // Check if the filename exists and is readable:
        if ( is_readable( $realPath ) )
        {
            // Attempt to get & set the MIME type.
            $mime                 = new eZMimeType ();
            $fileInfo["mimetype"] = $mime->mimeTypeFor( $dir, $file );
        }
        // Non-readable? -> MIME type fallback to 'application/x-non-readable'
        else
        {
            $fileInfo["mimetype"] = "application/x-non-readable";
        }
     }

    // Return the array (hopefully containing correct info).
    return $fileInfo;
}



/* The eZWebDAVFileServer class
   Enables local file administration/management through the WebDAV interface.
*/
class eZWebDAVFileServer extends eZWebDAVServer
{
    // Override head function.
    function head( $target )
    {
        // Make real path.
        $realPath = $_SERVER["DOCUMENT_ROOT"].$target;

        append_to_log( "HEAD: realPath is $realPath");

        // Check if the target file/dir really exists:
        if ( file_exists( $realPath ) )
        {
            return( EZ_WEBDAV_OK_CREATED );
        }
        else
        {
            return( EZ_WEBDAV_FAILED_NOT_FOUND );
        }
    }




    // Override put function.
    function put( $target, $tempFile )
    {
        // Make real path.
        $realPath = $_SERVER["DOCUMENT_ROOT"].$target;

        append_to_log( "PUT: realPath is $realPath" );
        append_to_log( "PUT: tempfile is $tempFile" );

        // Attempt to move the file from temp to desired location.
        $status = rename( $tempFile, $realPath );

        // Check status & return corresponding code:
        if ( $status )
        {
            append_to_log( "move of tempfile was OK" );
            // OK!
            return( EZ_WEBDAV_OK_CREATED );
        }
        else
        {
            append_to_log( "move of tempfile FAILED" );

            // No deal!
            return( EZ_WEBDAV_FAILED_FORBIDDEN );
        }
    }




    // Override get function.
    function get( $target )
    {
        $result         = array();
        $result["data"] = FALSE;
        $result["file"] = FALSE;

        // Set the file.
        $result["file"] = $_SERVER["DOCUMENT_ROOT"].$target;

        append_to_log( "GET: file is ".$result["file"]);

        return( $result );
    }




    // Override mkdir function.
    function mkcol( $target )
    {
        // Make real path.
        $realPath = $_SERVER["DOCUMENT_ROOT"].$target;

        append_to_log( "attempting to create dir: $realPath" );

        // Proceed only if the dir/file-name doesn't exist:
        if ( !file_exists( $realPath ) )
        {
            // Attempt to create the directory.
            $status = mkdir( $realPath );

            // Check status:
            if ( $status )
            {
                // OK:
                return( EZ_WEBDAV_OK_CREATED );
            }
            else
            {
                // No deal.
                return( EZ_WEBDAV_FAILED_FORBIDDEN );
            }
        }
        // Else: a dir/file with that name already exists:
        else
        {
            return( EZ_WEBDAV_FAILED_EXISTS );
        }
    }




    // Override delete function
    function delete( $target )
    {
        // Make real path.
        $realPath = $_SERVER["DOCUMENT_ROOT"].$target;

        append_to_log( "attempting to DELETE: $realPath" );

        // Check if the file actually exists (NULL compliance).
        if ( file_exists( $realPath ) )
        {
            append_to_log( "File/dir exists..." );

            // Check if target is a directory.
            if ( is_dir( $realPath ) )
            {
                // Attempt to remove the target directory.
                $status = delDir( $realPath );
            }
            // Else: the target is a file.
            else
            {
                append_to_log( "File is a file..." );

                // Attempt to remove the file.
                $status = unlink( $realPath );
            }

            // Check the return code:
            if ( $status )
            {
                append_to_log( "delete was OK" );
                // OK!
                return( EZ_WEBDAV_OK );
            }
            else
            {
                append_to_log( "delete FAILED" );

                // No deal!
                return( EZ_WEBDAV_FAILED_FORBIDDEN );
            }
        }
        else
        {
            // Non-existent file/dir:
            return( EZ_WEBDAV_FAILED_NOT_FOUND );
        }
    }




    // Override move function.
    function move( $source, $destination )
    {
        append_to_log( "Source: $source   Destination: $destination" );

        // Make real path to source and destination.
        $realSource      = $_SERVER["DOCUMENT_ROOT"].$source;
        $realDestination = $_SERVER["DOCUMENT_ROOT"].$destination;

        append_to_log( "RealSource: $realSource   RealDestination: $realDestination" );
        $status = rename( $realSource, $realDestination );

        if ( $status )
        {
            append_to_log( "move was OK" );
            // OK!
            return( EZ_WEBDAV_OK_CREATED );
        }
        else
        {
            append_to_log( "move FAILED" );

            // No deal!
            return( EZ_WEBDAV_FAILED_CONFLICT );
        }
    }




    // Override copy function.
    function copy( $source, $destination )
    {
        append_to_log( "Source: $source   Destination: $destination" );
        ob_start(); var_dump($_SERVER); $m = ob_get_contents(); ob_end_clean(); append_to_log($m);

        // Make real path to source and destination.
        $realSource      = $_SERVER["DOCUMENT_ROOT"].$source;
        $realDestination = $_SERVER["DOCUMENT_ROOT"].$destination;

        append_to_log( "RealSource: $realSource   RealDestination: $realDestination" );
        $status = copyDir( $realSource, $realDestination );

        if ( $status )
        {
            append_to_log( "copy was OK" );
            // OK!
            return( EZ_WEBDAV_OK_CREATED );
        }
        else
        {
            append_to_log( "copy FAILED" );

            // No deal!
            return( EZ_WEBDAV_FAILED_CONFLICT );
        }
    }



    // Override getCollectionContent function (dir list).
    function getCollectionContent( $dir )
    {
        $directory = dirname( $_SERVER["PATH_TRANSLATED"] ).$dir;

        $files  = array();

        append_to_log( "inside getDirectoryContent, dir: $directory" );
        $handle = opendir( $directory );

        // For all the entries in the directory:
        while ( $filename = readdir( $handle ) )
        {
            // Skip current and parent dirs ('.' and '..').
            if ( $filename != '.' && $filename != '..' )
            {
                // Get the file/dir info.
                $files[] = getFileInfo( $directory, $filename );
                append_to_log( "inside getDirectoryContent, dir: $directory, fil: $filename" );

            }
        }

        // Return array with file information.
        return $files;
    }
}





// Usage, simple:
//
//$myserver = new eZWebDAVFileServer();
//$myserver->processClientRequest();

?>
