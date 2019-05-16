<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (eregi("javascript.php",$PHP_SELF)) {
    Header("Location: ../index.php");
    die();
}

##################################################
# Include for some common javascripts functions  #
##################################################

if ($userpage == 1) {
    echo "<SCRIPT type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function showimage() {\n";
    echo "if (!document.images)\n";
    echo "return\n";
    echo "document.images.avatar.src=\n";
    echo "'$nukeurl/images/forum/avatar/' + document.Register.user_avatar.options[document.Register.user_avatar.selectedIndex].value\n";
    echo "}\n";
    echo "//-->\n";
    echo "</SCRIPT>\n\n";
}
if ($forumpage == 1) {
    echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n";
    echo "function x () {\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";    
    echo "function DoSmilie(addSmilie) {\n";
    echo "\n";
    echo "var addSmilie;\n";
    echo "var revisedMessage;\n";
    echo "var currentMessage = document.coolsus.message.value;\n";
    echo "revisedMessage = currentMessage+addSmilie;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "function DoPrompt(action) {\n";
    echo "var revisedMessage;\n";
    echo "var currentMessage = document.coolsus.message.value;\n";
    echo "\n";
    echo "if (action == \"url\") {\n";
    echo "var thisURL = prompt(\"Enter the URL for the link you want to add.\", \"http://\");\n";
    echo "var thisTitle = prompt(\"Enter the web site title\", \"Page Title\");\n";
    echo "var urlBBCode = \"[URL=\"+thisURL+\"]\"+thisTitle+\"[/URL]\";\n";
    echo "revisedMessage = currentMessage+urlBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"email\") {\n";
    echo "var thisEmail = prompt(\"Enter the email address you want to add.\", \"\");\n";
    echo "var emailBBCode = \"[EMAIL]\"+thisEmail+\"[/EMAIL]\";\n";
    echo "revisedMessage = currentMessage+emailBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"bold\") {\n";
    echo "var thisBold = prompt(\"Enter the text that you want to make bold.\", \"\");\n";
    echo "var boldBBCode = \"[B]\"+thisBold+\"[/B]\";\n";
    echo "revisedMessage = currentMessage+boldBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"italic\") {\n";
    echo "var thisItal = prompt(\"Enter the text that you want to make italic.\", \"\");\n";
    echo "var italBBCode = \"[I]\"+thisItal+\"[/I]\";\n";
    echo "revisedMessage = currentMessage+italBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"image\") {\n";
    echo "var thisImage = prompt(\"Enter the URL for the image you want to display.\", \"http://\");\n";
    echo "var imageBBCode = \"[IMG]\"+thisImage+\"[/IMG]\";\n";
    echo "revisedMessage = currentMessage+imageBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"quote\") {\n";
    echo "var quoteBBCode = \"[QUOTE]  [/QUOTE]\";\n";
    echo "revisedMessage = currentMessage+quoteBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"code\") {\n";
    echo "var codeBBCode = \"[CODE]  [/CODE]\";\n";
    echo "revisedMessage = currentMessage+codeBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"listopen\") {\n";
    echo "var liststartBBCode = \"[LIST]\";\n";
    echo "revisedMessage = currentMessage+liststartBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"listclose\") {\n";
    echo "var listendBBCode = \"[/LIST]\";\n";
    echo "revisedMessage = currentMessage+listendBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "if (action == \"listitem\") {\n";
    echo "var thisItem = prompt(\"Enter the new list item. Note that each list group must be preceeded by a List Close and must be ended with List Close.\", \"\");\n";
    echo "var itemBBCode = \"[*]\"+thisItem;\n";
    echo "revisedMessage = currentMessage+itemBBCode;\n";
    echo "document.coolsus.message.value=revisedMessage;\n";
    echo "document.coolsus.message.focus();\n";
    echo "return;\n";
    echo "}\n";
    echo "\n";
    echo "}\n";
    echo "//--></SCRIPT>\n";
    echo "\n";
}
if ($adminpage == 1) {
    echo "<script type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function openwindow(){\n";
    echo "	window.open (\"$hlpfile\",\"Help\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=400\");\n";
    echo "}\n";
    echo "//-->\n";
    echo "</SCRIPT>\n\n";
}

?>