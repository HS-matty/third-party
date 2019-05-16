<?php
//
// Created on: <17-Apr-2002 11:05:08 amos>
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

$Module =& $Params['Module'];

$text = "<p>Copyright (C) 1999-2004 eZ systems as. All rights reserved.</p>

<p>This file may be distributed and/or modified under the terms of the
\"GNU General Public License\" version 2 as published by the Free
Software Foundation and appearing in the file LICENSE included in
the packaging of this file.</p>

<p>Licencees holding a valid \"eZ publish professional licence\" version 2
may use this file in accordance with the \"eZ publish professional licence\"
version 2 Agreement provided with the Software.</p>

<p>This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.</p>

<p>The \"eZ publish professional licence\" version 2 is available at
<a href=\"http://ez.no/ez_publish/licences/professional/\">http://ez.no/ez_publish/licences/professional/</a> and in the file
PROFESSIONAL_LICENCE included in the packaging of this file.
For pricing of this licence please contact us via e-mail to licence@ez.no.
Further contact information is available at <a href=\"http://ez.no/company/contact/\">http://ez.no/company/contact/</a>.</p>

<p>The \"GNU General Public License\" (GPL) is available at
<a href=\"http://www.gnu.org/copyleft/gpl.html\">http://www.gnu.org/copyleft/gpl.html</a>.</p>

<p>Contact eZ system if any conditions of this licencing isn't clear to you.</p>";

$Result = array();
$Result['content'] = $text;
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'kernel/ezinfo', 'Info' ) ),
                         array( 'url' => false,
                                'text' => ezi18n( 'kernel/ezinfo', 'Copyright' ) ) );

?>
