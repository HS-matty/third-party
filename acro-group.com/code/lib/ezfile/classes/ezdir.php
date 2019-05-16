<?php
//
// Definition of eZDir class
//
// Created on: <02-Jul-2002 15:33:41 sp>
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

/*! \file ezdir.php
*/

/*!
  \class eZDir ezdir.php
  \brief The class eZDir does

*/
include_once( "lib/ezutils/classes/ezini.php" );
include_once( "lib/ezutils/classes/ezsys.php" );

define( 'EZ_DIR_SEPARATOR_LOCAL', 1 );
define( 'EZ_DIR_SEPARATOR_UNIX', 2 );
define( 'EZ_DIR_SEPARATOR_DOS', 3 );

class eZDir
{
    /*!
     Constructor
    */
    function eZDir()
    {
    }


    function getPathFromFilename( $filename )
    {
        $ini =& eZINI::instance();
        $dirDepth = $ini->variable( "FileSettings" , "DirDepth" );
        $pathArray = array();
        for ( $i = 0; $i < $dirDepth and $i < strlen( $filename ); $i++ )
        {
            $pathArray[] = substr( $filename, $i, 1 );
        }
        $path = implode( '/', $pathArray );

        return $path;
    }

    function filenamePath( $filename, $maxCharLen = 2 )
    {
        $path = '';
        for ( $i = 0; $i < strlen( $filename ) and ( strlen( $filename ) - $i ) > $maxCharLen;
              $i++ )
        {
            $path = $path . substr( $filename, $i, 1 ) . '/';
        }

        return $path;
    }

    /*!
     \static
     Creates the directory \a $dir with permissions \a $perm.
     If \a $parents is true it will create any missing parent directories,
     just like 'mkdir -p'.
    */
    function mkdir( $dir, $perm = false, $parents = false )
    {
        if ( $perm === false )
        {
            $perm = eZDir::directoryPermission();
        }
        $dir = eZDir::cleanPath( $dir, EZ_DIR_SEPARATOR_UNIX );
        if ( !$parents )
            return eZDir::doMkdir( $dir, $perm );
        else
        {
            $dirElements = explode( '/', $dir );
            if ( count( $dirElements ) == 0 )
                return true;
            $currentDir = $dirElements[0];
            $result = true;
            if ( !file_exists( $currentDir ) and $currentDir != "" )
                $result = eZDir::doMkdir( $currentDir, $perm );
            if ( !$result )
                return false;

            for ( $i = 1; $i < count( $dirElements ); ++$i )
            {
                $dirElement = $dirElements[$i];
                if ( strlen( $dirElement ) == 0 )
                    continue;
                $currentDir .= '/' . $dirElement;
                $result = true;
                if ( !file_exists( $currentDir ) )
                    $result = eZDir::doMkdir( $currentDir, $perm );
                if ( !$result )
                    return false;
            }
            return true;
        }
    }

    /*!
     \static
     Goes trough the directory path \a $dir and removes empty directories.
     \note This is just the opposite of mkdir() with \a $parents set to \c true.
    */
    function cleanupEmptyDirectories( $dir )
    {
        $dir = eZDir::cleanPath( $dir, EZ_DIR_SEPARATOR_UNIX );
        $dirElements = explode( '/', $dir );
        if ( count( $dirElements ) == 0 )
            return true;
        $currentDir = $dirElements[0];
        $result = true;
        if ( !file_exists( $currentDir ) and $currentDir != "" )
            $result = eZDir::doMkdir( $currentDir, $perm );
        if ( !$result )
            return false;

        for ( $i = count( $dirElements ); $i > 0; --$i )
        {
            $dirpath = implode( '/', array_slice( $dirElements, 0, $i ) );
            if ( file_exists( $dirpath ) and
                 is_dir( $dirpath ) )
            {
                $rmdirStatus = @rmdir( $dirpath );
                if ( !$rmdirStatus )
                    return true;
            }
        }
        return true;
    }

    /*!
     \return the dirpath portion of the filepath \a $filepath.
     \code
     $dirpath = eZDir::dirpath( "path/to/some/file.txt" );
     print( $dirpath ); // prints out path/to/some
     \endcode
    */
    function dirpath( $filepath )
    {
        $filepath = eZDir::cleanPath( $filepath, EZ_DIR_SEPARATOR_UNIX );
        $dirPosition = strrpos( $filepath, '/' );
        if ( $dirPosition !== false )
            return substr( $filepath, 0, $dirPosition );
        return $filepath;
    }

    /*!
     \return the default permissions to use for directories.
     \note The permission is converted from octal text to decimal value.
    */
     function directoryPermission()
    {
        $ini =& eZINI::instance();
        return octdec( $ini->variable( 'FileSettings', 'StorageDirPermissions' ) );
    }

    /*!
     \static
     \private
     Creates the directory \a $dir with permission \a $perm.
    */
    function doMkdir( $dir, $perm )
    {
        include_once( "lib/ezutils/classes/ezdebugsetting.php" );

        $oldumask = umask( 0 );
        if ( ! @mkdir( $dir, $perm ) )
        {
            umask( $oldumask );
			// eZDebug::writeError( "Couldn't create the directory \"$dir\".", "eZDir::doMkdir()" );
            return false;
        }
        umask( $oldumask );

        return true;
    }

    /*!
     \static
     \return the separator used between directories and files according to \a $type.

     Type can be one of the following:
     - EZ_DIR_SEPARATOR_LOCAL - Returns whatever is applicable for the current machine.
     - EZ_DIR_SEPARATOR_UNIX  - Returns a /
     - EZ_DIR_SEPARATOR_DOS   - Returns a \
    */
    function separator( $type )
    {
        switch ( $type )
        {
            case EZ_DIR_SEPARATOR_LOCAL:
                return eZSys::fileSeparator();
            case EZ_DIR_SEPARATOR_UNIX:
                return '/';
            case EZ_DIR_SEPARATOR_DOS:
                return "\\";
        }
        return null;
    }

    /*!
     \static
     Converts any directory separators found in \a $path, in both unix and dos style, into
     the separator type specified by \a $toType and returns it.
    */
    function convertSeparators( $path, $toType = EZ_DIR_SEPARATOR_UNIX )
    {
        $separator = eZDir::separator( $toType );
        return str_replace( array( '/', '\\' ), $separator, $path );
    }

    /*!
     \static
     Removes all unneeded directory separators and resolves any "."s and ".."s found in \a $path.

     For instance: "var/../lib/ezdb" becomes "lib/ezdb", while "../site/var" will not be changed.
     \note Will also convert separators
     \sa convertSeparators.
    */
    function cleanPath( $path, $toType = EZ_DIR_SEPARATOR_UNIX )
    {
        $path = eZDir::convertSeparators( $path, $toType );
        $separator = eZDir::separator( $toType );
        $path = preg_replace( "#$separator{2,}#", $separator, $path );
        $pathElements = explode( $separator, $path );
        $newPathElements = array();
        foreach ( $pathElements as $pathElement )
        {
            if ( $pathElement == '.' )
                continue;
            if ( $pathElement == '..' and
                 count( $newPathElements ) > 0 )
                array_pop( $newPathElements );
            else
                $newPathElements[] = $pathElement;
        }
        if ( count( $newPathElements ) == 0 )
            $newPathElements[] = '.';
        $path = implode( $separator, $newPathElements );
        return $path;
    }

    /*!
     \static
     Creates a path out of all the dir and file items in the array \a $names
     with correct separators in between them.
     It will also remove unneeded separators.
     \a $type is used to determine the separator type, see eZDir::separator.
     If \a $includeEndSeparator is true then it will make sure that the path ends with a
     separator if false it make sure there are no end separator.
    */
    function path( $names, $includeEndSeparator = false, $type = EZ_DIR_SEPARATOR_UNIX )
    {
        $separator = eZDir::separator( $type );
        $path = implode( $separator, $names );
        $path = eZDir::cleanPath( $path, $type );
        $pathLen = strlen( $path );
        $hasEndSeparator = ( $pathLen > 0 and
                         $path[$pathLen - 1] == $separator );
        if ( $includeEndSeparator and
             !$hasEndSeparator )
            $path .= $separator;
        else if ( !$includeEndSeparator and
                  $hasEndSeparator )
            $path = substr( $path, 0, $pathLen - 1 );
        return $path;
    }


    /*!
     \static
     Removes the directory and all it's contents, recursive.
    */
    function recursiveDelete( $dir )
    {
        if ( $handle = @opendir( $dir ) )
        {
            while ( ( $file = readdir( $handle ) ) !== false )
            {
                if ( ( $file == "." ) || ( $file == ".." ) )
                {
                    continue;
                }
                if ( is_dir( $dir . '/' . $file ) )
                {
                    eZDir::recursiveDelete( $dir . '/' . $file );
                }
                else
                {
                    unlink( $dir . '/' . $file );
                }
            }
            @closedir( $handle );
            rmdir( $dir );
        }
    }

    /*!
     \static
     Recurses through the directory and returns the files that matches the given suffix
     \note This function will not traverse . (hidden) folders
    */
    function &recursiveFind( $dir, $suffix )
    {
        $returnFiles = array();
        if ( $handle = @opendir( $dir ) )
        {
            while ( ( $file = readdir( $handle ) ) !== false )
            {
                if ( ( $file == "." ) || ( $file == ".." ) )
                {
                    continue;
                }
                if ( is_dir( $dir . '/' . $file ) )
                {
                    if ( $file[0] != "." )
                    {
                        $files =& eZDir::recursiveFind( $dir . '/' . $file, $suffix );
                        $returnFiles = array_merge( $files, $returnFiles );
                    }
                }
                else
                {
                    if ( preg_match( "/$suffix$/", $file ) )
                        $returnFiles[] = $dir . '/' . $file;
                }
            }
            @closedir( $handle );
        }
        return $returnFiles;
    }

    /*!
     \static
      Unlink files match the given pattern in the given directory.
    */
    function unlinkWildcard( $dir, $pattern )
    {
        $availableFiles = array();
        if ( $handle = @opendir( $dir ) )
        {
            while ( ( $file = readdir( $handle ) ) !== false )
            {
                if ( $file != "." && $file != ".." )
                {
                    $availableFiles[] = $file;
                }
            }
            @closedir( $handle );

            if( strpos( $pattern, "." ) )
            {
                $baseexp = substr( $pattern, 0, strpos( $pattern, "." ) );
                $typeexp = substr( $pattern, ( strpos( $pattern, "." ) + 1 ), strlen( $pattern ) );
            }
            else
            {
                $baseexp = $pattern;
                $typeexp = "";
            }

            $baseexp=preg_quote( $baseexp );
            $typeexp=preg_quote( $typeexp );

            $baseexp = str_replace( array( "\*", "\?" ), array( ".*", "." ), $baseexp );
            $typeexp = str_replace(array( "\*", "\?" ), array( ".*", "." ), $typeexp );

            $i=0;
            $matchedFileArray = array();
            foreach( $availableFiles as $file )
            {
                $fileName = basename( $file );

                if( strpos( $fileName, "." ) )
                {
                    $base = substr( $fileName, 0, strpos( $fileName, "."));
                    $type = substr( $fileName, ( strpos( $fileName,"." ) + 1 ), strlen( $fileName ) );
                }
                else
                {
                    $base = $fileName;
                    $type = "";
                }

                if( preg_match( "/^".$baseexp."$/i", $base ) && preg_match( "/^".$typeexp."$/i", $type ) )
                {
                    $matchedFileArray[$i] = $file;
                    $i++;
                }
            }

            foreach ( array_keys( $matchedFileArray ) as $key )
            {
                $matchedFile =& $matchedFileArray[$key];
                if ( substr( $dir,-1 ) == "/")
                {
                    unlink( $dir.$matchedFile );
                }
                else
                {
                    unlink( $dir."/".$matchedFile );
                }
            }
        }
    }

    /*!
     \static
     Recurses through the directory and returns the files that matches the given suffix.
     This function will store the relative path from the given base only.
     Note: this function will not traverse . (hidden) folders
    */
    function &recursiveFindRelative( $baseDir, $subDir, $suffix )
    {
        $returnFiles = array();
        $dir = $baseDir;
        if ( $subDir != "" )
        {
            if ( $dir != '' )
                $dir .= "/" . $subDir;
            else
                $dir .= $subDir;
        }
        if ( $handle = @opendir( $dir ) )
        {
            while ( ( $file = readdir( $handle ) ) !== false )
            {
                if ( ( $file == "." ) || ( $file == ".." ) )
                {
                    continue;
                }
                if ( is_dir( $dir . '/' . $file ) )
                {
                    if ( $file[0] != "." )
                    {
                        $files =& eZDir::recursiveFindRelative( $baseDir, $subDir . '/' . $file, $suffix );
                        $returnFiles = array_merge( $files, $returnFiles );
                    }
                }
                else
                {
                    if ( preg_match( "/$suffix$/", $file ) )
                        $returnFiles[] = $subDir . '/' . $file;
                }
            }
            @closedir( $handle );
        }
        return $returnFiles;
    }

    /*!
     \static
     Returns all subdirectories in a folder
    */
    function &findSubdirs( $dir, $includeHidden = false, $excludeItems = false )
    {
        return eZDir::findSubitems( $dir, 'd', false, $includeHidden, $excludeItems );
    }

    /*!
     \static
     Returns all subdirectories in a folder
    */
    function &findSubitems( $dir, $types = false, $fullPath = false, $includeHidden = false, $excludeItems = false )
    {
        if ( !$types )
            $types = 'dfl';
        $dirArray = array();
        if ( $handle = @opendir( $dir ) )
        {
            while ( ( $element = readdir( $handle ) ) !== false )
            {
                if ( $element == '.' or $element == '..' )
                    continue;
                if ( !$includeHidden and $element[0] == "." )
                    continue;
                if ( $excludeItems and preg_match( $excludeItems, $element ) )
                    continue;
                if ( is_dir( $dir . '/' . $element ) and strpos( $types, 'd' ) === false )
                    continue;
                if ( is_link( $dir . '/' . $element ) and strpos( $types, 'l' ) === false )
                    continue;
                if ( is_file( $dir . '/' . $element ) and strpos( $types, 'f' ) === false )
                    continue;
                if ( $fullPath )
                {
                    if ( is_string( $fullPath ) )
                        $dirArray[] = $fullPath . '/' . $element;
                    else
                        $dirArray[] = $dir . '/' . $element;
                }
                else
                    $dirArray[] = $element;
            }
            @closedir( $handle );
        }
        return $dirArray;
    }

    /*!
     Copies a directory (and optionally all it's subitems) to another directory.
    */
    function copy( $sourceDirectory, &$destinationDirectory,
                   $asChild = true, $recursive = true, $includeHidden = false, $excludeItems = false )
    {
        if ( !is_dir( $sourceDirectory ) )
        {
            eZDebug::writeError( "Source $sourceDirectory is not a directory, cannot copy from it",
                                 'eZDir::copy' );
            return false;
        }
        if ( !is_dir( $destinationDirectory ) )
        {
            eZDebug::writeError( "Destination $destinationDirectory is not a directory, cannot copy to it",
                                 'eZDir::copy' );
            return false;
        }
        if ( $asChild )
        {
            if ( preg_match( "#^.+/([^/]+)$#", $sourceDirectory, $matches ) )
            {
                eZDir::mkdir( $destinationDirectory . '/' . $matches[1], eZDir::directoryPermission(), false );
                $destinationDirectory .= '/' . $matches[1];
            }
        }
        $items = eZDir::findSubitems( $sourceDirectory, 'df', false, $includeHidden, $excludeItems );
        $totalItems = $items;
        while ( count( $items ) > 0 )
        {
            $currentItems = $items;
            $items = array();
            foreach ( $currentItems as $item )
            {
                $fullPath = $sourceDirectory . '/' . $item;
                if ( is_file( $fullPath ) )
                    eZFileHandler::copy( $fullPath, $destinationDirectory . '/' . $item );
                else if ( is_dir( $fullPath ) )
                {
                    eZDir::mkdir( $destinationDirectory . '/' . $item, eZDir::directoryPermission(), false );
                    $newItems = eZDir::findSubitems( $fullPath, 'df', $item, $includeHidden, $excludeItems );
                    $items = array_merge( $items, $newItems );
                    $totalItems = array_merge( $totalItems, $newItems );
                    unset( $newItems );
                }
            }
        }
//         eZDebugSetting::writeNotice( 'lib-ezfile-copy',
//                                      "Copied directory $sourceDirectory to destination $destinationDirectory",
//                                      'eZDir::copy' );
        return $totalItems;
    }

    /*!
     \return a regexp which will match certain temporary files.
    */
    function temporaryFileRegexp( $standalone = true )
    {
        $preg = '';
        if ( $standalone )
            $preg .= "/^";
        $preg .= "(.*~|#.+#|.*\.bak|.svn|CVS|.revive.el|.cvsignore)";
        if ( $standalone )
            $preg .= "$/";
        return $preg;
    }

    /*!
    \static
    Check if a given directory is writeable

    \return TRUE/FALSE
    */
    function isWriteable( $dirname )
    {
        if ( eZSys::osType() != 'win32' )
            return is_writable( $dirname );

        /* PHP function is_writable() doesn't work correctly on Windows NT descendants.
         * So we have to use the following hack on those OSes.
         * FIXME: maybe on Win9x we shouldn't do this?
         */
        $tmpfname = $dir . eZSys::fileSeparator() . "ezsetup_" . md5( microtime() ) . ".tmp";

        // try to create temporary file
        if ( !( $fp = @fopen( $tmpfname, "w" ) ) )
            return FALSE;

        fclose( $fp );
        unlink( $tmpfname );

        return TRUE;
    }
}

?>
