<?php
// This file contains functions which are common to all compiled templates.
//
// NOTE: This file is autogenerated and should not be modified, any changes will be lost!

define( "EZ_TEMPLATE_COMPILER_COMMON_CODE", true );

if ( !isset( $namespaceStack ) )
    $namespaceStack = array();

if ( !function_exists( 'compiledfetchvariable' ) )
{
    function compiledFetchVariable( &$vars, $namespace, $name )
    {
        $exists = ( array_key_exists( $namespace, $vars ) and
                    array_key_exists( $name, $vars[$namespace] ) );
        if ( $exists )
        {
            $var = $vars[$namespace][$name];
        }
        else
            $var = null;
        return $var;
    }
}
if ( !function_exists( 'compiledfetchtext' ) )
{
    function compiledFetchText( &$tpl, $rootNamespace, $currentNamespace, $namespace, &$var )
    {
        $text = '';
        $tpl->appendElement( $text, $var, $rootNamespace, $currentNamespace );
        return $text;
    }
}
if ( !function_exists( 'compiledAcquireResource' ) )
{
    function compiledAcquireResource( $phpScript, $key, &$originalText,
                                      &$tpl, $rootNamespace, $currentNamespace )
    {
        include( $phpScript );
        if ( isset( $text ) )
        {
            $originalText .= $text;
            return true;
        }
        return false;
    }
}
if ( !function_exists( 'compiledfetchattribute' ) )
{
    function compiledFetchAttribute( &$value, $attributeValue )
    {
        if ( is_object( $value ) )
        {
            if ( method_exists( $value, "attribute" ) and
                 method_exists( $value, "hasattribute" ) )
            {
                if ( $value->hasAttribute( $attributeValue ) )
                {
                    unset( $tempValue );
                    $tempValue = $value->attribute( $attributeValue );
                    return $tempValue;
                }
            }
        }
        else if ( is_array( $value ) )
        {
            if ( isset( $value[$attributeValue] ) )
            {
                unset( $tempValue );
                $tempValue = $value[$attributeValue];
                return $tempValue;
            }
        }
        return null;
    }
}
?>