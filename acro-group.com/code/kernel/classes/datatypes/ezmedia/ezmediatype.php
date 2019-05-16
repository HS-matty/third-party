<?php
//
// Definition of eZMediaType class
//
// Created on: <30-Apr-2002 13:06:21 bf>
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

/*!
  \class eZMediaType ezmediatype.php
  \ingroup eZKernel
  \brief The class eZMediaType handles storage and playback of media files.

*/

include_once( "kernel/classes/ezdatatype.php" );
include_once( "kernel/classes/datatypes/ezmedia/ezmedia.php" );
include_once( "lib/ezfile/classes/ezfile.php" );
include_once( "lib/ezutils/classes/ezmimetype.php" );
include_once( "lib/ezutils/classes/ezhttpfile.php" );
include_once( "lib/ezfile/classes/ezdir.php" );

define( "EZ_DATATYPESTRING_MEDIA", "ezmedia" );
define( 'EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_FIELD', 'data_int1' );
define( 'EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_VARIABLE', '_ezmedia_max_filesize_' );
define( "EZ_DATATYPESTRING_TYPE_FIELD", "data_text1" );
define( "EZ_DATATYPESTRING_TYPE_VARIABLE", "_ezmedia_type_" );

class eZMediaType extends eZDataType
{
    function eZMediaType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_MEDIA, ezi18n( 'kernel/classes/datatypes', "Media", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }

    function hasAttribute( $name )
    {
        return eZDataType::hasAttribute( $name );
    }

    function &attribute( $name )
    {
        return eZDataType::attribute( $name );
    }

    /*!
     Sets value according to current version
    */
    function initializeObjectAttribute( &$contentObjectAttribute, $currentVersion, &$originalContentObjectAttribute )
    {
        if ( $currentVersion !== false )
        {
            $contentObjectAttributeID = $originalContentObjectAttribute->attribute( "id" );
            $version = $contentObjectAttribute->attribute( "version" );
            $oldfile =& eZMedia::fetch( $contentObjectAttributeID, $currentVersion );
            if( $oldfile != null )
            {
                $oldfile->setAttribute( 'contentobject_attribute_id', $contentObjectAttribute->attribute( 'id' ) );
                $oldfile->setAttribute( "version",  $version );
                $oldfile->store();
            }
        }
    }

    /*!
     Delete stored attribute
    */
    function deleteStoredObjectAttribute( &$contentObjectAttribute, $version = null )
    {
        $contentObjectAttributeID = $contentObjectAttribute->attribute( "id" );
        $mediaFiles =& eZMedia::fetch( $contentObjectAttributeID );
        $sys =& eZSys::instance();
        $storage_dir = $sys->storageDirectory();
        if( $version == null )
        {
            foreach ( $mediaFiles as $mediaFile )
            {
                $mimeType =  $mediaFile->attribute( "mime_type" );
                list( $prefix, $suffix ) = split ('[/]', $mimeType );
//                $orig_dir = "var/storage/original/" . $prefix;
                $orig_dir = $storage_dir . '/original/' . $prefix;
                $fileName = $mediaFile->attribute( "filename" );
                if( file_exists( $orig_dir . "/" .$fileName ) )
                    unlink( $orig_dir . "/" . $fileName );
            }
        }
        else
        {
            $count = 0;
            $currentBinaryFile =& eZMedia::fetch( $contentObjectAttributeID, $version );
            if ( $currentBinaryFile != null )
            {
                $mimeType =  $currentBinaryFile->attribute( "mime_type" );
                $currentFileName = $currentBinaryFile->attribute( "filename" );
                list( $prefix, $suffix ) = split ('[/]', $mimeType );
//              $orig_dir = "var/storage/original/" . $prefix;
                $orig_dir = $storage_dir . '/original/' . $prefix;
                foreach ( $mediaFiles as $mediaFile )
                {
                    $fileName = $mediaFile->attribute( "filename" );
                    if( $currentFileName == $fileName )
                        $count += 1;
                }
                if( $count == 1 )
                {
                    if( file_exists( $orig_dir . "/" . $currentFileName ) )
                        unlink( $orig_dir . "/" .  $currentFileName );
                }
            }
        }
        eZMedia::remove( $contentObjectAttributeID, $version );
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        $httpFileName = $base . "_data_mediafilename_" . $contentObjectAttribute->attribute( "id" );
        $maxSize = 1024 * 1024 * $classAttribute->attribute( EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_FIELD );
        $mustUpload = false;

        if ( $classAttribute->attribute( "is_required" ) == true )
        {
            $contentObjectAttributeID = $contentObjectAttribute->attribute( "id" );
            $version = $contentObjectAttribute->attribute( "version" );
            $media =& eZMedia::fetch( $contentObjectAttributeID, $version );
            if ( $media === null )
            {
                $mustUpload = true;
            }
        }

        $canFetchResult = eZHTTPFile::canFetch( $httpFileName, $maxSize );
        if ( $mustUpload && $canFetchResult == EZ_UPLOADEDFILE_DOES_NOT_EXIST )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                'A valid file is required.' ) );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }
        if ( $canFetchResult == EZ_UPLOADEDFILE_EXCEEDS_PHP_LIMIT )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                'Size of uploaded file exceeds limit set by upload_max_filesize directive in php.ini.' ) );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }
        if ( $canFetchResult == EZ_UPLOADEDFILE_EXCEEDS_MAX_SIZE )
        {
            $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                'Size of uploaded file exceeds %1 bytes.' ), $maxSize );
            return EZ_INPUT_VALIDATOR_STATE_INVALID;
        }
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     Fetches input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $classAttribute =& $contentObjectAttribute->contentClassAttribute();
        $player = $classAttribute->attribute( "data_text1" );
        switch( $player )
        {
            case 'flash':
                $plugin = "http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash";
            break;
            case 'quick_time':
                $plugin = "http://quicktime.apple.com";
            break;
            case 'real_player' :
                $plugin = "http://www.real.com/";
            break;
            case 'windows_media_player' :
                $plugin = "http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112" ;
            break;
            default:
                $plugin = "";
            break;
        }
        $contentObjectAttributeID = $contentObjectAttribute->attribute( "id" );
        $version = $contentObjectAttribute->attribute( "version" );
        $width = $http->postVariable( $base . "_data_media_width_" . $contentObjectAttribute->attribute( "id" ) );
        $height = $http->postVariable( $base . "_data_media_height_" . $contentObjectAttribute->attribute( "id" ) );
        $quality = $http->postVariable( $base . "_data_media_quality_" . $contentObjectAttribute->attribute( "id" ) );
        $controls = $http->postVariable( $base . "_data_media_controls_" . $contentObjectAttribute->attribute( "id" ) );

        $mediaFile =& eZHTTPFile::fetch( $base . "_data_mediafilename_" . $contentObjectAttribute->attribute( "id" ) );

        if ( get_class( $mediaFile ) == "ezhttpfile" )
        {
            $mimeData =& eZMimeType::findByFileContents( $mediaFile->attribute( "original_filename" ) );
            $mime = $mimeData['name'];

            if ( $mime == '' )
            {
                $mime = $mediaFile->attribute( "mime_type" );
            }
            $extension = preg_replace('/.*\.(.+?)$/', '\\1', $mediaFile->attribute( "original_filename" ) );
            if ( !$mediaFile->store( "original", $extension ) )
            {
                eZDebug::writeError( "Failed to store http-file: " . $mediaFile->attribute( "original_filename" ),
                                     "eZMediaType" );
                return false;
            }

            $media =& eZMedia::fetch( $contentObjectAttributeID, $version );
            if ( $media == null )
            {
                $media =& eZMedia::create( $contentObjectAttributeID, $version );
            }

            $orig_dir = $mediaFile->storageDir( "original" );
            eZDebug::writeNotice( "dir=$orig_dir" );
            $media->setAttribute( "contentobject_attribute_id", $contentObjectAttributeID );
            $media->setAttribute( "version", $version );
            $media->setAttribute( "filename", basename( $mediaFile->attribute( "filename" ) ) );
            $media->setAttribute( "original_filename", $mediaFile->attribute( "original_filename" ) );
            $media->setAttribute( "mime_type", $mime );
            $media->setAttribute( "width", $width );
            $media->setAttribute( "height", $height );
            $media->setAttribute( "quality", $quality );
            $media->setAttribute( "controls", $controls );
            $media->setAttribute( "pluginspage", $plugin );
            if ( $http->hasPostVariable( $base . "_data_media_is_autoplay_" . $contentObjectAttribute->attribute( "id" ) ) )
                $media->setAttribute( "is_autoplay", true );
            else
                $media->setAttribute( "is_autoplay", false );
            if ( $http->hasPostVariable( $base . "_data_media_has_controller_" . $contentObjectAttribute->attribute( "id" ) ) )
                $media->setAttribute( "has_controller", true );
            else
                $media->setAttribute( "has_controller", false );
            if ( $http->hasPostVariable( $base . "_data_media_is_loop_" . $contentObjectAttribute->attribute( "id" ) ) )
                $media->setAttribute( "is_loop", true );
            else
                $media->setAttribute( "is_loop", false );
            $media->store();
            $contentObjectAttribute->setContent( $media );
        }
        else
        {
            $media =& eZMedia::fetch( $contentObjectAttributeID, $version );
            if ( $media === null )
            {
                eZDebug::writeError("No file uploaded");
            }
            else
            {
                $media->setAttribute( "width", $width );
                $media->setAttribute( "height", $height );
                $media->setAttribute( "quality", $quality );
                $media->setAttribute( "controls", $controls );
                $media->setAttribute( "pluginspage", $plugin );
                if ( $http->hasPostVariable( $base . "_data_media_is_autoplay_" . $contentObjectAttribute->attribute( "id" ) ) )
                    $media->setAttribute( "is_autoplay", true );
                else
                    $media->setAttribute( "is_autoplay", false );
                if ( $http->hasPostVariable( $base . "_data_media_has_controller_" . $contentObjectAttribute->attribute( "id" ) ) )
                    $media->setAttribute( "has_controller", true );
                else
                    $media->setAttribute( "has_controller", false );
                if ( $http->hasPostVariable( $base . "_data_media_is_loop_" . $contentObjectAttribute->attribute( "id" ) ) )
                    $media->setAttribute( "is_loop", true );
                else
                    $media->setAttribute( "is_loop", false );
                $media->store();
                $contentObjectAttribute->setContent( $media );
            }
        }
        return true;
    }

    function storeObjectAttribute( &$contentObjectAttribute )
    {
    }

    function customObjectAttributeHTTPAction( $http, $action, &$contentObjectAttribute )
    {
        if( $action == "delete_media" )
        {
            $contentObjectAttributeID = $contentObjectAttribute->attribute( "id" );
            $version = $contentObjectAttribute->attribute( "version" );
            $this->deleteStoredObjectAttribute( $contentObjectAttribute, $version );
        }
    }

    function storeClassAttribute( &$attribute, $version )
    {
    }

    function storeDefinedClassAttribute( &$attribute )
    {
    }

    /*!
     \reimp
    */
    function validateClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     \reimp
    */
    function fixupClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
    }

    /*!
     \reimp
    */
    function fetchClassAttributeHTTPInput( &$http, $base, &$classAttribute )
    {
        $filesizeName = $base . EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_VARIABLE . $classAttribute->attribute( 'id' );
        $typeName = $base . EZ_DATATYPESTRING_TYPE_VARIABLE . $classAttribute->attribute( 'id' );
        if ( $http->hasPostVariable( $filesizeName ) )
        {
            $filesizeValue = $http->postVariable( $filesizeName );
            $classAttribute->setAttribute( EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_FIELD, $filesizeValue );
        }
        if ( $http->hasPostVariable( $typeName ) )
        {
            $typeValue = $http->postVariable( $typeName );
            $classAttribute->setAttribute( EZ_DATATYPESTRING_TYPE_FIELD, $typeValue );
        }
    }

    /*!
     Returns the object title.
    */
    function title( &$contentObjectAttribute,  $name = "original_filename" )
    {
        $mediaFile =& eZMedia::fetch( $contentObjectAttribute->attribute( "id" ),
                                      $contentObjectAttribute->attribute( "version" ) );

        if ( $mediaFile != null )
            $value = $mediaFile->attribute( $name );
        else
            $value = "";
        return $value;
    }

    function hasObjectAttributeContent( &$contentObjectAttribute )
    {
        $mediaFile =& eZMedia::fetch( $contentObjectAttribute->attribute( "id" ),
                                      $contentObjectAttribute->attribute( "version" ) );

        if ( $mediaFile != null )
            return true;
        return false;
    }

    function &objectAttributeContent( $contentObjectAttribute )
    {
        $mediaFile =& eZMedia::fetch( $contentObjectAttribute->attribute( "id" ),
                                      $contentObjectAttribute->attribute( "version" ) );
        if ( !$mediaFile )
        {
            return false;
        }
        return $mediaFile;
    }

    function metaData()
    {
        return "";
    }

    /*!
     \reimp
    */
    function &serializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $maxSize = $classAttribute->attribute( EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_FIELD );
        $type = $classAttribute->attribute( EZ_DATATYPESTRING_TYPE_FIELD );
        $attributeParametersNode->appendChild( eZDOMDocument::createElementTextNode( 'max-size', $maxSize,
                                                                                     array( 'unit-size' => 'mega' ) ) );
        $attributeParametersNode->appendChild( eZDOMDocument::createElementTextNode( 'type', $type ) );
    }

    /*!
     \reimp
    */
    function &unserializeContentClassAttribute( &$classAttribute, &$attributeNode, &$attributeParametersNode )
    {
        $maxSize = $attributeParametersNode->elementTextContentByName( 'max-size' );
        $sizeNode = $attributeParametersNode->elementByName( 'max-size' );
        $unitSize = $sizeNode->attributeValue( 'unit-size' );
        $type = $attributeParametersNode->elementTextContentByName( 'type' );
        $classAttribute->setAttribute( EZ_DATATYPESTRING_MAX_MEDIA_FILESIZE_FIELD, $maxSize );
        $classAttribute->setAttribute( EZ_DATATYPESTRING_TYPE_FIELD, $type );
    }

    /*!
     \param package
     \param content attribute

     \return a DOM representation of the content object attribute
    */
    function &serializeContentObjectAttribute( &$package, &$objectAttribute )
    {
        $node = new eZDOMNode();

        $node->setPrefix( 'ezobject' );
        $node->setName( 'attribute' );
        $node->appendAttribute( eZDOMDocument::createAttributeNode( 'id', $objectAttribute->attribute( 'id' ), 'ezremote' ) );
        $node->appendAttribute( eZDOMDocument::createAttributeNode( 'identifier', $objectAttribute->contentClassAttributeIdentifier(), 'ezremote' ) );
        $node->appendAttribute( eZDOMDocument::createAttributeNode( 'name', $objectAttribute->contentClassAttributeName() ) );
        $node->appendAttribute( eZDOMDocument::createAttributeNode( 'type', $this->isA() ) );

        $mediaFile =& $objectAttribute->attribute( 'content' );
        $fileKey = md5( mt_rand() );
        include_once( 'kernel/classes/ezbinaryfilehandler.php' );
        $package->appendSimpleFile( $fileKey, eZBinaryFileHandler::storedFilename( $mediaFile ) );

        $mediaNode =& eZDOMDocument::createElementNode( 'media-file' );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'filesize', $mediaFile->attribute( 'filesize' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'filename', $mediaFile->attribute( 'filename' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'original-filename', $mediaFile->attribute( 'original_filename' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'mime-type', $mediaFile->attribute( 'mime_type' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'filekey', $fileKey ) );

        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'width', $mediaFile->attribute( 'width' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'height', $mediaFile->attribute( 'height' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'has-controller', $mediaFile->attribute( 'has_controller' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'controls', $mediaFile->attribute( 'controls' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'is-autoplay', $mediaFile->attribute( 'is_autoplay' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'plugins-page', $mediaFile->attribute( 'plugingspage' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'quality', $mediaFile->attribute( 'quality' ) ) );
        $mediaNode->appendAttribute( eZDOMDocument::createAttributeNode( 'is-loop', $mediaFile->attribute( 'is_loop' ) ) );
        $node->appendChild( $mediaNode );

        return $node;
    }

    /*!
     \reimp
     \param package
     \param contentobject attribute object
     \param ezdomnode object
    */
    function unserializeContentObjectAttribute( &$package, &$objectAttribute, $attributeNode )
    {
        $mediaNode = $attributeNode->elementByName( 'media-file' );
        $mediaFile =& eZMedia::create( $objectAttribute->attribute( 'id' ), $objectAttribute->attribute( 'version' ) );

        $sourcePath = $package->simpleFilePath( $mediaNode->attributeValue( 'filekey' ) );

        include_once( 'lib/ezfile/classes/ezdir.php' );
        $ini =& eZINI::instance();
        $mimeType = $mediaNode->attributeValue( 'mime-type' );
        list( $mimeTypeCategory, $mimeTypeName ) = explode( '/', $mimeType );
        $destinationPath = eZSys::storageDirectory() . '/original/' . $mimeTypeCategory . '/';
        if ( !file_exists( $destinationPath ) )
        {
            $oldumask = umask( 0 );
            if ( !eZDir::mkdir( $destinationPath, eZDir::directoryPermission(), true ) )
            {
                umask( $oldumask );
                return false;
            }
            umask( $oldumask );
        }

        $basename = basename( $mediaNode->attributeValue( 'filename' ) );
        while ( file_exists( $destinationPath . $basename ) )
        {
            $basename = substr( md5( mt_rand() ), 0, 8 ) . '.' . eZFile::suffix( $mediaNode->attributeValue( 'filename' ) );
        }

        include_once( 'lib/ezfile/classes/ezfilehandler.php' );
        eZFileHandler::copy( $sourcePath, $destinationPath . $basename );
        eZDebug::writeNotice( 'Copied: ' . $sourcePath . ' to: ' . $destinationPath . $basename,
                              'eZMediaType::unserializeContentObjectAttribute()' );

        $mediaFile->setAttribute( 'contentobject_attribute_id', $objectAttribute->attribute( 'id' ) );
        $mediaFile->setAttribute( 'filename', $basename );
        $mediaFile->setAttribute( 'original_filename', $mediaNode->attributeValue( 'original-filename' ) );
        $mediaFile->setAttribute( 'mime_type', $mediaNode->attributeValue( 'mime-type' ) );

        $mediaFile->setAttribute( 'width', $mediaNode->attributeValue( 'width' ) );
        $mediaFile->setAttribute( 'height', $mediaNode->attributeValue( 'height' ) );
        $mediaFile->setAttribute( 'has_controller', $mediaNode->attributeValue( 'has-controller' ) );
        $mediaFile->setAttribute( 'controls', $mediaNode->attributeValue( 'controls' ) );
        $mediaFile->setAttribute( 'is_autoplay', $mediaNode->attributeValue( 'is-autoplay' ) );
        $mediaFile->setAttribute( 'pluginspage', $mediaNode->attributeValue( 'plugins-page' ) );
        $mediaFile->setAttribute( 'quality', $mediaNode->attributeValue( 'quality' ) );
        $mediaFile->setAttribute( 'is_loop', $mediaNode->attributeValue( 'is-loop' ) );

        $mediaFile->store();
    }
}

eZDataType::register( EZ_DATATYPESTRING_MEDIA, "ezmediatype" );

?>
