<?php
//
// Definition of eZAuthorType class
//
// Created on: <19-Aug-2002 10:51:10 bf>
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
  \class eZAuthorType ezauthortype.php
  \ingroup eZKernel
  \brief eZAuthorType handles multiple authors

*/

include_once( "kernel/classes/ezdatatype.php" );
include_once( "kernel/classes/datatypes/ezauthor/ezauthor.php" );
include_once( "lib/ezutils/classes/ezmail.php" );

define( "EZ_DATATYPESTRING_AUTHOR", "ezauthor" );

class eZAuthorType extends eZDataType
{
    function eZAuthorType()
    {
        $this->eZDataType( EZ_DATATYPESTRING_AUTHOR, ezi18n( 'kernel/classes/datatypes', "Author", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $classAttribute =& $contentObjectAttribute->contentClassAttribute();
            $idList = $http->postVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) );
            $nameList = $http->postVariable( $base . "_data_author_name_" . $contentObjectAttribute->attribute( "id" ) );
            $emailList = $http->postVariable( $base . "_data_author_email_" . $contentObjectAttribute->attribute( "id" ) );
            if ( $classAttribute->attribute( "is_required" ) == true )
            {
                if ( trim( $nameList[0] ) == "" )
                {
                    $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                         'At least one author is required.' ) );
                    return EZ_INPUT_VALIDATOR_STATE_INVALID;
                }
            }
            if ( trim( $nameList[0] ) != "" )
            {
                for ( $i=0;$i<count( $idList );$i++ )
                {
                    $name =  $nameList[$i];
                    $email =  $emailList[$i];
                    if ( trim( $name )== "" )
                    {
                        $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                             'Author name should be provided.' ) );
                        return EZ_INPUT_VALIDATOR_STATE_INVALID;

                    }
                    $isValidate =  eZMail::validate( $email );
                    if ( ! $isValidate )
                    {
                        $contentObjectAttribute->setValidationError( ezi18n( 'kernel/classes/datatypes',
                                                                             'Email address is not valid.' ) );
                        return EZ_INPUT_VALIDATOR_STATE_INVALID;
                    }
                }
            }
        }
        return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
    }

    /*!
     Store content
    */
    function storeObjectAttribute( &$contentObjectAttribute )
    {
        $author =& $contentObjectAttribute->content();
        $contentObjectAttribute->setAttribute( "data_text", $author->xmlString() );
    }

    /*!
     Returns the content.
    */
    function &objectAttributeContent( &$contentObjectAttribute )
    {
        $author = new eZAuthor( );

        if ( trim( $contentObjectAttribute->attribute( "data_text" ) ) != "" )
        {
            $author->decodeXML( $contentObjectAttribute->attribute( "data_text" ) );
            $temp = $contentObjectAttribute->attribute( "data_text");
        }
        else
        {
            $user =& eZUser::currentUser();
            $userobject =& $user->attribute( 'contentobject' );
            if ( $userobject )
            {
                $author->addAuthor( $userobject->attribute( 'name' ), $user->attribute( 'email' ) );
            }
         }

        if ( count( $author->attribute( 'author_list' ) ) == 0 )
        {
//             $author->addAuthor( "Default", "" );
        }

        return $author;
    }


    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( &$contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_text" );
    }

    /*!
     Fetches the http post var integer input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( &$http, $base, &$contentObjectAttribute )
    {
        $authorIDArray =& $http->postVariable( $base . "_data_author_id_" . $contentObjectAttribute->attribute( "id" ) );
        $authorNameArray =& $http->postVariable( $base . "_data_author_name_" . $contentObjectAttribute->attribute( "id" ) );
        $authorEmailArray =& $http->postVariable( $base . "_data_author_email_" . $contentObjectAttribute->attribute( "id" ) );

        $author = new eZAuthor( );

        $i = 0;
        foreach ( $authorIDArray as $id )
        {
            $author->addAuthor( $authorNameArray[$i], $authorEmailArray[$i] );
            $i++;
        }
        $contentObjectAttribute->setContent( $author );
        return true;
    }

    /*!
    */
    function customObjectAttributeHTTPAction( $http, $action, &$contentObjectAttribute )
    {
        switch ( $action )
        {
            case "new_author" :
            {
                $author =& $contentObjectAttribute->content( );

                $author->addAuthor( "" );
                $contentObjectAttribute->setContent( $author );
            }break;
            case "remove_selected" :
            {
                $author =& $contentObjectAttribute->content( );
                $postvarname = "ContentObjectAttribute" . "_data_author_remove_" . $contentObjectAttribute->attribute( "id" );
                $array_remove = $http->postVariable( $postvarname );
                $author->removeAuthors( $array_remove );
                $contentObjectAttribute->setContent( $author );
            }break;
            default :
            {
                eZDebug::writeError( "Unknown custom HTTP action: " . $action, "eZAuthorType" );
            }break;
        }
    }

    function hasObjectAttributeContent( &$contentObjectAttribute )
    {
        $author =& $contentObjectAttribute->content( );
        $authorList = $author->attribute( 'author_list' );
        return count( $authorList ) > 0;
    }

    /*!
     Returns the integer value.
    */
    function title( &$contentObjectAttribute )
    {
        $author =& $contentObjectAttribute->content( );

        $value = $author->attribute( $name );

        return $value;
    }

    /*!
     \reimp
    */
    function isIndexable()
    {
        return true;
    }

    /*!
     \reimp
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

        $xml = new eZXML();
        $domDocument = $xml->domTree( $objectAttribute->attribute( 'data_text' ) );
        $node->appendChild( $domDocument->root() );

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
        $rootNode = $attributeNode->firstChild();
        $objectAttribute->setAttribute( 'data_text', $rootNode->toString( 0 ) );
    }

}

eZDataType::register( EZ_DATATYPESTRING_AUTHOR, "ezauthortype" );

?>
